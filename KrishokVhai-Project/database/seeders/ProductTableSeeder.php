<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Auth;
use Spatie\MediaLibrary\Exceptions\FileCannotBeAdded\DiskDoesNotExist;
use Spatie\MediaLibrary\Exceptions\FileCannotBeAdded\FileDoesNotExist;
use Spatie\MediaLibrary\Exceptions\FileCannotBeAdded\FileIsTooBig;

class ProductTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $cate = new ProductCategory();
        $cate->title = 'Crop';
        $cate->slug = 'crop';
        $cate->user_id = 1;
        $cate->save();

        $cate = new ProductCategory();
        $cate->title = 'Fruit';
        $cate->slug = 'fruit';
        $cate->user_id = 1;
        $cate->save();

        $cate = new ProductCategory();
        $cate->title = 'Vegetables';
        $cate->slug = 'vegetables';
        $cate->user_id = 1;
        $cate->save();

        $cate = new ProductCategory();
        $cate->title = 'Livestock';
        $cate->slug = 'livestock';
        $cate->user_id = 1;
        $cate->save();

        $cate = new ProductCategory();
        $cate->title = 'Aquaculture';
        $cate->slug = 'aquaculture';
        $cate->user_id = 1;
        $cate->save();

        $cate = new ProductCategory();
        $cate->title = 'Spices';
        $cate->slug = 'spices';
        $cate->user_id = 1;
        $cate->save();

        #--------------------------------------------------------------------
        #--------------------------------------------------------------------
        #--------------------------------------------------------------------

        $cate = new ProductCategory();
        $cate->title = 'Sugarcane';
        $cate->slug = 'sugarcane';
        $cate->user_id = 1;
        $cate->parent_id = 1;
        $cate->save();

        $cate = new ProductCategory();
        $cate->title = 'Cow';
        $cate->slug = 'cow';
        $cate->user_id = 1;
        $cate->parent_id = 4;
        $cate->save();

        $cate = new ProductCategory();
        $cate->title = 'Buffalo';
        $cate->slug = 'buffalo';
        $cate->user_id = 1;
        $cate->parent_id = 4;
        $cate->save();

        $cate = new ProductCategory();
        $cate->title = 'Potato';
        $cate->slug = 'potato';
        $cate->user_id = 1;
        $cate->parent_id = 3;
        $cate->save();

        $cate = new ProductCategory();
        $cate->title = 'Tomato';
        $cate->slug = 'tomato';
        $cate->user_id = 1;
        $cate->parent_id = 3;
        $cate->save();

        $cate = new ProductCategory();
        $cate->title = 'Sheep';
        $cate->slug = 'sheep';
        $cate->user_id = 1;
        $cate->parent_id = 4;
        $cate->save();

        $cate = new ProductCategory();
        $cate->title = 'Goat';
        $cate->slug = 'goat';
        $cate->user_id = 1;
        $cate->parent_id = 4;
        $cate->save();

        $cate = new ProductCategory();
        $cate->title = 'Rui';
        $cate->slug = 'rui';
        $cate->user_id = 1;
        $cate->parent_id = 5;
        $cate->save();

        $cate = new ProductCategory();
        $cate->title = 'Talapia';
        $cate->slug = 'talapia';
        $cate->user_id = 1;
        $cate->parent_id = 5;
        $cate->save();


        $cate = new ProductCategory();
        $cate->title = 'Rice';
        $cate->slug = 'rice';
        $cate->user_id = 1;
        $cate->parent_id = 1;
        $cate->save();

        $cate = new ProductCategory();
        $cate->title = 'Mango';
        $cate->slug = 'mango';
        $cate->user_id = 1;
        $cate->parent_id = 2;
        $cate->save();

        $cate = new ProductCategory();
        $cate->title = 'Lychee';
        $cate->slug = 'lychee';
        $cate->user_id = 1;
        $cate->parent_id = 2;
        $cate->save();

        $cate = new ProductCategory();
        $cate->title = 'Jackfruit';
        $cate->slug = 'jackfruit';
        $cate->user_id = 1;
        $cate->parent_id = 2;
        $cate->save();

        $cate = new ProductCategory();
        $cate->title = 'Banana';
        $cate->slug = 'banana';
        $cate->user_id = 1;
        $cate->parent_id = 2;
        $cate->save();

        $cate = new ProductCategory();
        $cate->title = 'Cabbage';
        $cate->slug = 'cabbage';
        $cate->user_id = 1;
        $cate->parent_id = 3;
        $cate->save();

        $cate = new ProductCategory();
        $cate->title = 'Wheat';
        $cate->slug = 'wheat';
        $cate->user_id = 1;
        $cate->parent_id = 1;
        $cate->save();

        $cate = new ProductCategory();
        $cate->title = 'Corn';
        $cate->slug = 'corn';
        $cate->user_id = 1;
        $cate->parent_id = 1;
        $cate->save();


        #--------------------------------------------------------------------
        #--------------------------------------------------------------------
        #--------------------------------------------------------------------

        $product = new Product();
        $product->product_name = 'Mango';
        $product->description = 'Sweet mango from rajshahi.';
        $product->brand_id = null;
        $product->total_stock = 1000;
        $product->stock_type = 'kg';
        $product->regular_price = 35;
        $product->retail_price = 30;
        $product->minimum_order_amount = 20;
        $product->seller_id = 10;
        $product->save();
        $product->productCategory()->attach(17);

        try {
            $file1 = 'https://images.financialexpress.com/2019/04/mango-1.jpg';
            $file2 = 'https://cdn.harvesttotable.com/htt/2019/11/23181833/Mango-bigstock-Tropical-Mango-Tree-With-Big-R-288199537-1024x683.jpg';
            $file3 = 'http://photos1.blogger.com/blogger/6129/1076/1600/mango_tree.jpg';
            $product->addMediaFromUrl($file1)->toMediaCollection('products');
            $product->addMediaFromUrl($file2)->toMediaCollection('products');
            $product->addMediaFromUrl($file3)->toMediaCollection('products');
        } catch (DiskDoesNotExist | FileDoesNotExist | FileIsTooBig $e) {
            return response()->json(['error', $e], 500);
        }


        $product = new Product();
        $product->product_name = 'Bombay Lychee';
        $product->description = 'Bombay lychee from dinajpur.';
        $product->brand_id = null;
        $product->total_stock = 1000;
        $product->stock_type = 'kg';
        $product->regular_price = 60;
        $product->retail_price = 50;
        $product->minimum_order_amount = 5;
        $product->seller_id = 11;
        $product->save();
        $product->productCategory()->attach(18);

        try {
            $file1 = 'https://newsd.in/wp-content/uploads/2018/10/Litchi.jpg';
            $file2 = 'https://www.agrifarming.in/wp-content/uploads/2015/08/Litchi-Fruit-Tree.-577x330.png?x73645';
            $product->addMediaFromUrl($file1)->toMediaCollection('products');
            $product->addMediaFromUrl($file2)->toMediaCollection('products');
        } catch (DiskDoesNotExist | FileDoesNotExist | FileIsTooBig $e) {
            return response()->json(['error', $e], 500);
        }


        $product = new Product();
        $product->product_name = 'Lychee';
        $product->description = 'Lychee from rajshahi.';
        $product->brand_id = null;
        $product->total_stock = 1000;
        $product->stock_type = 'kg';
        $product->regular_price = 60;
        $product->retail_price = 50;
        $product->minimum_order_amount = 5;
        $product->seller_id = 10;
        $product->save();
        $product->productCategory()->attach(18);

        try {
            $file1 = 'https://agrifarming.in/wp-content/uploads/2015/08/Litchi-Fruit-Farming.jpg?x35884';
            $file2 = 'https://2.bp.blogspot.com/-nanDE7o-Wuc/T9_-8uhTl3I/AAAAAAAACM0/p8YJ_2kzZSM/s1600/Lychee_Litchi_Chinensis_sweet_tasty_fruit02_ripe.jpg';
            $file3 = 'https://im01.itaiwantrade.com/715bd316-4b69-4cfb-b1db-55260e49e99d/Taiwan_litchi_Yan_Li.jpg';
            $product->addMediaFromUrl($file1)->toMediaCollection('products');
            $product->addMediaFromUrl($file2)->toMediaCollection('products');
            $product->addMediaFromUrl($file3)->toMediaCollection('products');
        } catch (DiskDoesNotExist | FileDoesNotExist | FileIsTooBig $e) {
            return response()->json(['error', $e], 500);
        }


        $product = new Product();
        $product->product_name = 'Lychee';
        $product->description = 'Lychee from rajshahi.';
        $product->brand_id = null;
        $product->total_stock = 1000;
        $product->stock_type = 'kg';
        $product->regular_price = 60;
        $product->retail_price = 50;
        $product->minimum_order_amount = 5;
        $product->seller_id = 2;
        $product->save();
        $product->productCategory()->attach(18);

        try {
            $file1 = 'https://www.theayurveda.org/wp-content/uploads/2016/10/pink-litchi-fruit.png';
            $file2 = 'http://www.freshexotic.co/wp-content/uploads/2020/04/lychee-4390099_1920-1024x683.jpg';
            $product->addMediaFromUrl($file1)->toMediaCollection('products');
            $product->addMediaFromUrl($file2)->toMediaCollection('products');
        } catch (DiskDoesNotExist | FileDoesNotExist | FileIsTooBig $e) {
            return response()->json(['error', $e], 500);
        }


        $product = new Product();
        $product->product_name = 'Jackfruit';
        $product->description = 'Jackfruit from dinajpur.';
        $product->brand_id = null;
        $product->total_stock = 1000;
        $product->stock_type = 'piece';
        $product->regular_price = 60;
        $product->retail_price = 50;
        $product->minimum_order_amount = 5;
        $product->seller_id = 11;
        $product->save();
        $product->productCategory()->attach(19);

        try {
            $file1 = 'https://i.ytimg.com/vi/QcS752xP9_Q/maxresdefault.jpg';
            $file2 = 'https://www.utkaltoday.com/wp-content/uploads/2020/04/jackfruit.jpg';
            $product->addMediaFromUrl($file1)->toMediaCollection('products');
            $product->addMediaFromUrl($file2)->toMediaCollection('products');
        } catch (DiskDoesNotExist | FileDoesNotExist | FileIsTooBig $e) {
            return response()->json(['error', $e], 500);
        }


        $product = new Product();
        $product->product_name = 'Rice';
        $product->description = 'Rice from dinajpur.';
        $product->brand_id = null;
        $product->total_stock = 4;
        $product->stock_type = 'lbs';
        $product->regular_price = 60;
        $product->retail_price = 50;
        $product->minimum_order_amount = 5;
        $product->seller_id = 10;
        $product->save();
        $product->productCategory()->attach(16);

        try {
            $file1 = 'https://live.staticflickr.com/7920/45909507155_85741cfa80_b.jpg';
            $product->addMediaFromUrl($file1)->toMediaCollection('products');
        } catch (DiskDoesNotExist | FileDoesNotExist | FileIsTooBig $e) {
            return response()->json(['error', $e], 500);
        }

        $product = new Product();
        $product->product_name = 'Corn';
        $product->description = 'Corn from barishal.';
        $product->brand_id = null;
        $product->total_stock = 1000;
        $product->stock_type = 'piece';
        $product->regular_price = 30;
        $product->retail_price = 25;
        $product->minimum_order_amount = 5;
        $product->seller_id = 2;
        $product->save();
        $product->productCategory()->attach(23);

        try {
            $file1 = 'https://ekaloria.com/wp-content/uploads-ekaloria-en/2013/06/Corn.jpg';
            $file2 = 'https://images.wisegeek.com/fresh-corn-on-the-cob.jpg';
            $file3 = 'https://scitechdaily.com/images/Sweet-Corn-Bounty.jpg';
            $product->addMediaFromUrl($file1)->toMediaCollection('products');
            $product->addMediaFromUrl($file2)->toMediaCollection('products');
            $product->addMediaFromUrl($file3)->toMediaCollection('products');
        } catch (DiskDoesNotExist | FileDoesNotExist | FileIsTooBig $e) {
            return response()->json(['error', $e], 500);
        }


        $product = new Product();
        $product->product_name = 'Sugarcane';
        $product->description = 'Sugarcane from barishal.';
        $product->brand_id = null;
        $product->total_stock = 1000;
        $product->stock_type = 'piece';
        $product->regular_price = 60;
        $product->retail_price = 50;
        $product->minimum_order_amount = 5;
        $product->seller_id = 2;
        $product->save();
        $product->productCategory()->attach(7);

        try {
            $file1 = 'http://desibantu.com/wp-content/uploads/2014/06/cane_desibatu.jpg';
            $file2 = 'https://www.awf.org/sites/default/files/public/media/gallery_0/Countries/Tanzania/ClimateSmartAgriculture_Sugarcane_Tanzania.jpg';
            $product->addMediaFromUrl($file1)->toMediaCollection('products');
            $product->addMediaFromUrl($file2)->toMediaCollection('products');
        } catch (DiskDoesNotExist | FileDoesNotExist | FileIsTooBig $e) {
            return response()->json(['error', $e], 500);
        }



        $product = new Product();
        $product->product_name = 'Cow';
        $product->description = 'Cow.';
        $product->brand_id = null;
        $product->total_stock = 1;
        $product->stock_type = 'piece';
        $product->regular_price = 1800000;
        $product->retail_price = 1800000;
        $product->minimum_order_amount = 1;
        $product->seller_id = 2;
        $product->save();
        $product->productCategory()->attach(8);

        try {
            $file1 = 'http://2.bp.blogspot.com/-CXFfl9luHPM/TV-Os6opQfI/AAAAAAAAA2E/oCgrgvWqzrY/s1600/cow.jpg';
            $product->addMediaFromUrl($file1)->toMediaCollection('products');
        } catch (DiskDoesNotExist | FileDoesNotExist | FileIsTooBig $e) {
            return response()->json(['error', $e], 500);
        }



        $product = new Product();
        $product->product_name = 'Goat';
        $product->description = 'Dasi goat.';
        $product->brand_id = null;
        $product->total_stock = 1;
        $product->stock_type = 'piece';
        $product->regular_price = 18000;
        $product->retail_price = 18000;
        $product->minimum_order_amount = 1;
        $product->seller_id = 2;
        $product->save();
        $product->productCategory()->attach(13);

        try {
            $file1 = 'http://4.bp.blogspot.com/-WuqLzs5YlbA/TtANNV38KYI/AAAAAAAADgs/rKODMlsK040/s1600/goat.jpg';
            $product->addMediaFromUrl($file1)->toMediaCollection('products');
        } catch (DiskDoesNotExist | FileDoesNotExist | FileIsTooBig $e) {
            return response()->json(['error', $e], 500);
        }

        $product = new Product();
        $product->product_name = 'Cow';
        $product->description = 'Cow.';
        $product->brand_id = null;
        $product->total_stock = 1;
        $product->stock_type = 'piece';
        $product->regular_price = 28500;
        $product->retail_price = 28500;
        $product->minimum_order_amount = 1;
        $product->seller_id = 2;
        $product->save();
        $product->productCategory()->attach(8);

        try {
            $file1 = 'https://saveindiancows.org/wp-content/uploads/2017/08/Indian-cow.jpg';
            $product->addMediaFromUrl($file1)->toMediaCollection('products');
        } catch (DiskDoesNotExist | FileDoesNotExist | FileIsTooBig $e) {
            return response()->json(['error', $e], 500);
        }


        $product = new Product();
        $product->product_name = 'Indian cow';
        $product->description = 'Indian cow.';
        $product->brand_id = null;
        $product->total_stock = 1;
        $product->stock_type = 'piece';
        $product->regular_price = 285000;
        $product->retail_price = 285000;
        $product->minimum_order_amount = 1;
        $product->seller_id = 2;
        $product->save();
        $product->productCategory()->attach(8);

        try {
            $file1 = 'https://assets.nst.com.my/images/articles/MR_TRUMPCow2_1564827223.jpg';
            $product->addMediaFromUrl($file1)->toMediaCollection('products');
        } catch (DiskDoesNotExist | FileDoesNotExist | FileIsTooBig $e) {
            return response()->json(['error', $e], 500);
        }


    }
}
