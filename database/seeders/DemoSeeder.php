<?php

namespace Database\Seeders;

use App\Models\Catagory;
use App\Models\Comment;
use App\Models\Oder;
use App\Models\Product;
use App\Models\Reply;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DemoSeeder extends Seeder
{
    public const ADMIN_EMAIL = 'admin@bezzey.example';

    public const CUSTOMER_EMAIL = 'customer@bezzey.example';

    public const DEMO_PASSWORD = 'password';

    public function run(): void
    {
        Model::unguard();

        $admin = $this->user(
            self::ADMIN_EMAIL,
            'Bezzey Admin',
            '1',
            '03001234567',
            'Bezzey Studio, Clifton, Karachi'
        );
        $customer = $this->user(
            self::CUSTOMER_EMAIL,
            'Amina Qureshi',
            '0',
            '03007654321',
            '14 Gallery Road, Clifton, Karachi'
        );

        foreach (['Apparel', 'Footwear', 'Accessories', 'Home'] as $name) {
            Catagory::firstOrCreate(['catagory_name' => $name]);
        }

        $products = [];
        foreach ($this->catalog() as $row) {
            $product = Product::firstOrNew(['title' => $row['title']]);
            $fresh = ! $product->exists;
            $product->discription = $row['discription'];
            $product->image = $row['image'];
            $product->catagory = $row['catagory'];
            $product->price = $row['price'];
            $product->discount_price = $row['discount_price'];
            if ($fresh) {
                $product->quantity = $row['quantity'];
            }
            $product->save();
            $products[$row['title']] = $product;
        }

        $this->commentThread($products['Harbor Cotton Tee'], $customer, $admin);
        $this->sampleOrders($customer, $products);
    }

    private function user(string $email, string $name, string $usertype, string $phone, string $address): User
    {
        $user = User::firstOrNew(['email' => $email]);
        $user->name = $name;
        $user->usertype = $usertype;
        $user->phone = $phone;
        $user->address = $address;
        $user->password = Hash::make(self::DEMO_PASSWORD);
        $user->email_verified_at = $user->email_verified_at ?? now();
        $user->save();

        return $user;
    }

    private function commentThread(Product $product, User $customer, User $admin): void
    {
        $comment = Comment::firstOrNew([
            'pro_id' => $product->id,
            'user_id' => $customer->id,
        ]);
        $comment->name = $customer->name;
        $comment->comment = 'Soft cotton, true to size, and easy to dress up. Wore it to a Friday market and it still looked sharp.';
        $comment->save();

        $reply = Reply::firstOrNew([
            'comment_id' => $comment->id,
            'user_id' => $admin->id,
        ]);
        $reply->name = $admin->name;
        $reply->reply = 'Thank you, Amina. This tee is cut a little relaxed so it layers under a jacket.';
        $reply->save();
    }

    private function sampleOrders(User $customer, array $products): void
    {
        $samples = [
            [
                'product' => $products['Harbor Cotton Tee'],
                'quantity' => 1,
                'payment_status' => 'On Delivery',
                'delivery_status' => 'Processing',
            ],
            [
                'product' => $products['Studio Ceramic Mug'],
                'quantity' => 2,
                'payment_status' => 'Paid',
                'delivery_status' => 'Deliverd',
            ],
        ];

        foreach ($samples as $sample) {
            $product = $sample['product'];
            $exists = Oder::where('user_id', $customer->id)
                ->where('product_id', $product->id)
                ->where('payment_status', $sample['payment_status'])
                ->exists();
            if ($exists) {
                continue;
            }

            $unit = $product->discount_price !== null && $product->discount_price !== ''
                ? $product->discount_price
                : $product->price;

            Oder::create([
                'name' => $customer->name,
                'email' => $customer->email,
                'address' => $customer->address,
                'phone' => $customer->phone,
                'product_title' => $product->title,
                'quantity' => $sample['quantity'],
                'price' => (int) $unit * $sample['quantity'],
                'image' => $product->image,
                'product_id' => $product->id,
                'user_id' => $customer->id,
                'payment_status' => $sample['payment_status'],
                'delivery_status' => $sample['delivery_status'],
            ]);

            $remaining = (int) $product->quantity - $sample['quantity'];
            $product->quantity = $remaining > 0 ? $remaining : 0;
            $product->save();
        }
    }

    private function catalog(): array
    {
        return [
            [
                'title' => 'Harbor Cotton Tee',
                'discription' => 'Heavyweight white tee with a clean crew neck. Fictional Bezzey house style.',
                'image' => 'demo/harbor-cotton-tee.jpg',
                'catagory' => 'Apparel',
                'price' => '36',
                'discount_price' => '28',
                'quantity' => '24',
            ],
            [
                'title' => 'Northline Wool Coat',
                'discription' => 'Camel wool wrap coat with a tie belt. A winter layer for the demo catalog.',
                'image' => 'demo/northline-wool-coat.jpg',
                'catagory' => 'Apparel',
                'price' => '180',
                'discount_price' => null,
                'quantity' => '8',
            ],
            [
                'title' => 'Cedar Market Tote',
                'discription' => 'Structured market tote for books and groceries. No branding, just canvas.',
                'image' => 'demo/cedar-canvas-tote.jpg',
                'catagory' => 'Accessories',
                'price' => '32',
                'discount_price' => '26',
                'quantity' => '30',
            ],
            [
                'title' => 'Marlowe Sunglasses',
                'discription' => 'Round metal frames with green lenses. A fictional Bezzey accessory.',
                'image' => 'demo/marlowe-sunglasses.jpg',
                'catagory' => 'Accessories',
                'price' => '54',
                'discount_price' => '42',
                'quantity' => '18',
            ],
            [
                'title' => 'Riverbed Sneakers',
                'discription' => 'Color-blocked sneakers with a chunky sole. Demo footwear, not a branded shoe.',
                'image' => 'demo/riverbed-sneakers.jpg',
                'catagory' => 'Footwear',
                'price' => '89',
                'discount_price' => null,
                'quantity' => '14',
            ],
            [
                'title' => 'Clifton Chinos',
                'discription' => 'Tapered khaki chinos for everyday wear. Part of the fictional catalog.',
                'image' => 'demo/clifton-chinos.jpg',
                'catagory' => 'Apparel',
                'price' => '58',
                'discount_price' => '49',
                'quantity' => '20',
            ],
            [
                'title' => 'Studio Ceramic Mug',
                'discription' => 'Matte ceramic mug for the desk. Sold as a pair in the sample order.',
                'image' => 'demo/amber-ceramic-mug.jpg',
                'catagory' => 'Home',
                'price' => '18',
                'discount_price' => null,
                'quantity' => '40',
            ],
            [
                'title' => 'Lumen Task Lamp',
                'discription' => 'Matte task lamp with an adjustable shade. Home piece for the demo shop.',
                'image' => 'demo/lumen-desk-lamp.jpg',
                'catagory' => 'Home',
                'price' => '74',
                'discount_price' => '64',
                'quantity' => '11',
            ],
            [
                'title' => 'Field Knit Poncho',
                'discription' => 'Cream open-knit poncho with fringe. Light layer from the apparel demo.',
                'image' => 'demo/field-knit-poncho.jpg',
                'catagory' => 'Apparel',
                'price' => '64',
                'discount_price' => null,
                'quantity' => '12',
            ],
        ];
    }
}
