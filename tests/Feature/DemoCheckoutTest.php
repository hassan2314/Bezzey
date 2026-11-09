<?php

namespace Tests\Feature;

use App\Models\Cart;
use App\Models\Oder;
use App\Models\Product;
use App\Models\User;
use App\Notifications\Email;
use Database\Seeders\DemoSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class DemoCheckoutTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        config([
            'services.stripe.key' => null,
            'services.stripe.secret' => null,
        ]);
    }

    public function test_demo_seed_creates_catalog_and_logins(): void
    {
        $this->seed();

        $admin = User::where('email', DemoSeeder::ADMIN_EMAIL)->first();
        $customer = User::where('email', DemoSeeder::CUSTOMER_EMAIL)->first();

        $this->assertNotNull($admin);
        $this->assertSame('1', (string) $admin->usertype);
        $this->assertNotNull($admin->email_verified_at);
        $this->assertTrue(\Illuminate\Support\Facades\Hash::check(DemoSeeder::DEMO_PASSWORD, $admin->password));

        $this->assertNotNull($customer);
        $this->assertSame('0', (string) $customer->usertype);
        $this->assertSame(9, Product::count());
        $this->assertSame(2, Oder::count());

        $this->get('/')->assertOk()->assertSee('Harbor Cotton Tee');
        $this->actingAs($admin)->get('/show_product')->assertOk()->assertSee('Northline Wool Coat');
        $this->actingAs($admin)->get('/order')->assertOk()->assertSee('Studio Ceramic Mug');
        $this->actingAs($admin)->get('/redirect')->assertOk()->assertSee('Total Products');
    }

    public function test_cash_on_delivery_checks_out_without_stripe_keys(): void
    {
        $this->seed();
        $customer = User::where('email', DemoSeeder::CUSTOMER_EMAIL)->first();
        $product = Product::where('title', 'Cedar Market Tote')->first();

        $cart = new Cart();
        $cart->name = $customer->name;
        $cart->email = $customer->email;
        $cart->address = $customer->address;
        $cart->phone = $customer->phone;
        $cart->product_title = $product->title;
        $cart->quantity = 1;
        $cart->price = $product->discount_price;
        $cart->image = $product->image;
        $cart->product_id = $product->id;
        $cart->user_id = $customer->id;
        $cart->save();

        $this->actingAs($customer)->get('/cash_order')->assertRedirect('/show_order');

        $this->assertSame(0, Cart::where('user_id', $customer->id)->count());
        $this->assertDatabaseHas('oders', [
            'user_id' => $customer->id,
            'product_title' => 'Cedar Market Tote',
            'payment_status' => 'On Delivery',
            'delivery_status' => 'Processing',
        ]);

        $this->actingAs($customer)
            ->get('/stripe/26')
            ->assertRedirect('/show_cart');
    }

    public function test_card_checkout_is_offered_only_when_test_keys_are_present(): void
    {
        $this->seed();
        $customer = User::where('email', DemoSeeder::CUSTOMER_EMAIL)->first();

        config([
            'services.stripe.key' => 'pk_test_placeholder',
            'services.stripe.secret' => 'sk_test_placeholder',
        ]);

        $this->actingAs($customer)
            ->get('/stripe/40')
            ->assertOk()
            ->assertSee('pk_test_placeholder', false);
    }

    public function test_customer_email_is_sent_through_the_mail_channel(): void
    {
        $this->seed();
        $admin = User::where('email', DemoSeeder::ADMIN_EMAIL)->first();
        $order = Oder::first();

        Notification::fake();

        $this->withoutMiddleware(\App\Http\Middleware\VerifyCsrfToken::class);
        $this->actingAs($admin)->post('/send_user_email/'.$order->id, [
            'greeting' => 'Hello',
            'firstline' => 'Your demo order is packed.',
            'body' => 'This message is fictional.',
            'button' => 'View the shop',
            'url' => 'http://127.0.0.1:8000',
            'lastline' => 'Thank you for shopping at Bezzey.',
        ])->assertRedirect();

        Notification::assertSentTo($order, Email::class);
        $this->assertSame('log', config('mail.default'));
    }
}
