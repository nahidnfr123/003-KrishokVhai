<?php

namespace Database\Seeders;

use App\Models\Post;
use App\Models\PostCategory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
use Spatie\MediaLibrary\Exceptions\FileCannotBeAdded\DiskDoesNotExist;
use Spatie\MediaLibrary\Exceptions\FileCannotBeAdded\FileDoesNotExist;
use Spatie\MediaLibrary\Exceptions\FileCannotBeAdded\FileIsTooBig;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $cate = new PostCategory();
        $cate->title = 'Farming practice';
        $cate->slug = 'farming-practice';
        $cate->user_id = 1;
        $cate->save();

        $cate = new PostCategory();
        $cate->title = 'Crop';
        $cate->slug = 'crop';
        $cate->user_id = 1;
        $cate->parent_id = 1;
        $cate->save();

        $cate = new PostCategory();
        $cate->title = 'Crop Care';
        $cate->slug = 'crop-care';
        $cate->user_id = 1;
        $cate->parent_id = 2;
        $cate->save();

        $cate = new PostCategory();
        $cate->title = 'Improved Rice Cultivation';
        $cate->slug = 'improved-rice-cultivation';
        $cate->user_id = 1;
        $cate->parent_id = 3;
        $cate->save();

        $cate = new PostCategory();
        $cate->title = 'Crop Storage';
        $cate->slug = 'crop-storage';
        $cate->user_id = 1;
        $cate->parent_id = 2;
        $cate->save();

        $cate = new PostCategory();
        $cate->title = 'Crop Health & Nutrition';
        $cate->slug = 'crop-health-&-nutrition';
        $cate->user_id = 1;
        $cate->parent_id = 2;
        $cate->save();

        $cate = new PostCategory();
        $cate->title = 'Planting';
        $cate->slug = 'planting';
        $cate->user_id = 1;
        $cate->parent_id = 1;
        $cate->save();

        $cate = new PostCategory();
        $cate->title = 'Beef Cattle Farming';
        $cate->slug = 'beef-cattle-farming';
        $cate->user_id = 1;
        $cate->parent_id = 1;
        $cate->save();

        $cate = new PostCategory();
        $cate->title = 'Poultry Farming';
        $cate->slug = 'poultry-farming';
        $cate->user_id = 1;
        $cate->parent_id = 1;
        $cate->save();

        $cate = new PostCategory();
        $cate->title = 'Goat Farming';
        $cate->slug = 'goat-farming';
        $cate->user_id = 1;
        $cate->parent_id = 1;
        $cate->save();

        $cate = new PostCategory();
        $cate->title = 'Soil Improvement Techniques';
        $cate->slug = 'soil-improvement-techniques';
        $cate->user_id = 1;
        $cate->parent_id = 1;
        $cate->save();

        $cate = new PostCategory();
        $cate->title = 'Intensive Fruit Farming';
        $cate->slug = 'intensive-fruit-farming';
        $cate->user_id = 1;
        $cate->parent_id = 1;
        $cate->save();

        $cate = new PostCategory();
        $cate->title = 'Seeds';
        $cate->slug = 'seeds';
        $cate->user_id = 1;
        $cate->save();


        $cate = new PostCategory();
        $cate->title = 'Quality seed';
        $cate->slug = 'quality-seed';
        $cate->user_id = 1;
        $cate->parent_id = 13;
        $cate->save();

        $cate = new PostCategory();
        $cate->title = 'Seed Preparation';
        $cate->slug = 'seed-preparation';
        $cate->user_id = 1;
        $cate->parent_id = 13;
        $cate->save();

        $cate = new PostCategory();
        $cate->title = 'Weather Mitigation';
        $cate->slug = 'weather-mitigation';
        $cate->user_id = 1;
        $cate->save();

        $cate = new PostCategory();
        $cate->title = 'Machinery';
        $cate->slug = 'machinery';
        $cate->user_id = 1;
        $cate->save();

        $cate = new PostCategory();
        $cate->title = 'Fertilizer';
        $cate->slug = 'fertilizer';
        $cate->user_id = 1;
        $cate->save();

        $cate = new PostCategory();
        $cate->title = 'General';
        $cate->slug = 'general';
        $cate->user_id = 1;
        $cate->save();
###############################################


        # Post 1 #:------------------------------------------------------------
        $post = new Post();
        $post->title = 'পেঁপে চারা রোপণের সঠিক সময়';
        $post->slug = 'পেঁপে-চারা-রোপণের-সঠিক-সময়';
        $post->type = 'farming-practice';
        $post->status = true;
        $post->user_id = 1;
        $post->author = 'Nahid Ferdous';
        $post->description = '<p>আশ্বিন মাসে পেঁপে চারা রোপণ করার উপযুক্ত সময়। এ সময়ে রোপণ করা পেঁপের গাছ লম্বা হয় না। এ কারণে ঝড়ে পেঁপে গাছ ভেঙে পড়ার সম্ভাবনা থাকে না। তাই পেঁপে গাছে খুঁটি দেয়ার ব্যবস্থা না করলেও হয়। আশ্বিনে রোপণ করা পেঁপে গাছ পরবর্তী চার মাস শীতের কারণে বৃদ্ধি পায় না। এ সময়ে গাছের পাতাও ঝরে যায়। শীতের শেষে ফাল্গুন মাসের শুরুতে কিছুটা উষ্ণ আবহাওয়ায় সার ও পানি সেচ দিলে ওই সময়ে পেঁপে গাছ ছোট থাকলেও গাছের বয়স বেড়ে যাওয়ায় ছোট গাছেই ফুল আসে এবং ফল ধরে।</p><p>পেঁপের চারার বয়স ৩৫ থেকে ৪০ দিন হলেই রোপণ করা যায়। এ সময় চারার উচ্চতা সাধারণত ১৫ সেন্টিমিটারের মত হয়। রোপণের জন্য যে স্থান নির্বাচন করা হয়, সে স্থানটি অবশ্যই সুনিষ্কাশিত হতে হবে। অর্থাৎ কোনোক্রমেই পেঁপের জমিতে যেন পানি জমতে না পারে, সেদিকে লক্ষ্য রেখেই জমি নির্বাচন করতে হবে। জমি তৈরির পর রোপণ দূরত্ব অনুযায়ী সারি বরাবর বেড তৈরি করতে হবে। দুই সারির মাঝের স্থান থেকে এমনভাবে মাটি তুলে নিয়ে দু’পাশে রাখতে হবে যাতে দু’সারির মাঝে একটি নালা তৈরি করা যায় এবং বেডগুলো দু’দিকে নালা বরাবর ঢালু হয়। বেড ঢালু করার কারণ হল কোনোক্রমেই যেন পানি বেডের উপর না জমে, দু’দিকের নালায় গড়িয়ে যায়।</p><p>২.০ থেকে ২.৫ মিটার পর পর সারি করে সারিতে একই দূরত্বে ৪৫ থেকে ৬০ সেন্টিমিটার চওড়া ও ৪৫ থেকে ৬০ সে.মি. গভীর গর্ত করে রোপণ করতে হয়। গর্তের মাটি ঝুরঝুরে করে মাটির সাথে জৈব সার মিশিয়ে দিতে হয়। চারা রোপণের ৩ থেকে ৪ দিন আগে রাসায়নিক সার মেশাতে হয়।</p><p><strong>প্রতি গর্তে</strong></p><p>১৫ কেজি জৈব সার,</p><p>৫০০ গ্রাম টিএসপি,</p><p>২৫০ গ্রাম জিপসাম,</p><p>২৫ গ্রাম বোরিক এসিড এবং</p><p>২০ গ্রাম জিংক সালফেট</p><p>একসাথে ভালভাবে গর্তের মাটির সাথে মিশিয়ে দিতে হবে। পেঁপের চারা লাগানোর পর গাছে নতুন পাতা গজানোর সাথে সাথে প্রতি গাছে ৫০ গ্রাম ইউরিয়া ও ৫০ গ্রাম এমওপি সার প্রয়োগ করতে হবে। এরপর শীতের শেষে ফাল্গুনের শুরুতে প্রতি পেঁপে গাছে ১০০ গ্রাম ইউরিয়া, ১০০ গ্রাম টিএসপি ও ১০০ গ্রাম এমওপি সার উপরি প্রয়োগ করতে হবে। গাছে ফল ধরার পর গাছপ্রতি এ মাত্রা দ্বিগুণ করতে হবে।</p><p>প্রতি গর্তে ২০ থেকে ২৫ সে.মি দূরত্বে দু’টি চারা রোপণ করা যেতে পারে। তবে একটি চারাও রোপণ করা যায়। পেঁপের চারা রোপণের ২ থেকে ৩ দিন আগে গর্তটি জৈব সার মিশ্রিত মাটি দিয়ে ভরাট করতে হবে। গাছে ফুল আসার পর পুরুষ গাছ বা স্ত্রী গাছ বুঝা যায় এবং তখন <strong>ক্ষেতে শতকরা ৫টি পুরুষ গাছ রেখে বাকিগুলো কেটে ফেলতে হয়।</strong> এক সাথে দু’টি গাছ রাখা ঠিক নয়।</p><p>চারা রোপণের আগে পলিব্যাগ থেকে চারা বের করার সময় একটি ব্লেড দিয়ে পলিব্যাগের একদিক চিরে দিতে হবে। এরপর চারার মাটির বলটি যেন ভেঙে না যায় বা চারার শিকড়ের কোনোরকম ক্ষতি না হয়, সেদিকে লক্ষ্য রেখে চারাটি গর্তের ভরাট করা মাটিতে হাত দিয়ে চারার মাটির বলের আকারের চেয়ে একটু বড় গর্ত করে সে গর্তে স্থাপন করতে হবে। চারার গোড়া পলিব্যাগে যতটুকু বাইরে ছিল ঠিক ততটুকুই বাইরে বা উপরে রেখে রোপণ করতে হবে। কখনোই চারার গোড়া বেশি গভীরে পুতে দেয়া বা চারার গোড়ায় অতিরিক্ত মাটি দেয়া উচিত নয়। এতে চারা গোড়াপচা রোগে আক্রান্ত হতে পারে। এ সময়ে চারার গোড়ায় প্রথম ১ থেকে ২ দিন কোনো পানি সেচের প্রয়োজন হয় না। তবে পাতার ওপরে হালকা করে হাত দিয়ে ছিটিয়ে পানি দেয়া যেতে পারে।</p><p>পেঁপের বাগানে পেঁপে গাছের গোড়া সব সময় পরিষ্কার রাখা দরকার। শীতের সময় টুকুতে পেঁপে বাগানে সাথী ফসল হিসেবে লাল শাক, পালং শাক, ধনে শাক, লেটুস, বেগুন, মরিচ চাষ করা যেতে পারে। তবে টমেটো, বেগুন ও কপি জাতীয় সবজি চাষ না করাই ভাল। কারণ এসব সবজিতে জাব পোকার আক্রমণ বেশি হয় বলে পেঁপে গাছও জাব পোকার দ্বারা আক্রান্ত হতে পারে।</p><p>শীতের আগে রোপণ করা পেঁপে গাছে সাধারণত ৪ থেকে ৫ মাসে ফুল ধরে এবং ৬ থেকে ৭ মাসে কাঁচা পেঁপে সংগ্রহ করা যায়। প্রথম দিকে গাছে প্রচুর পেঁপে ধরে। এগুলোর মধ্য থেকে কিছু কিছু পেঁপে ফল ছাঁটাই করতে হবে অর্থাৎ ফল সংগ্রহ করে পাতলা করতে হবে। তাহলে অন্য পেঁপেগুলো যখন পরিপক্ব হয়, তখন বড় আকারের হয়। আর রোপণের ১০ থেকে ১১ মাস পর পরিপক্ব পেঁপে ফল সংগ্রহ করা যায়।</p>';
        $post->save();
        foreach ([19] as $categoryId) {
            $post->postCategory()->attach($categoryId);
        }
        try {
            $file1 = 'http://nicolesyblog.com/wp-content/uploads/2009/12/Old-4.jpg';
            $file2 = 'https://www.louiesnursery.com/wp-content/uploads/2017/06/papaya-tree-stock-image-1024x683.jpg';
            $post->addMediaFromUrl($file1)->toMediaCollection('posts');
            $post->addMediaFromUrl($file2)->toMediaCollection('posts');
        } catch (DiskDoesNotExist | FileDoesNotExist | FileIsTooBig $e) {
            return response()->json(['error', $e], 500);
        }


        # Post 2 #:------------------------------------------------------------
        $post = new Post();
        $post->title = 'Boro procurement: Govt’s delay worries farmers.';
        $post->slug = 'boro-procurement-govts-delay-worries-farmers';
        $post->type = 'news';
        $post->status = true;
        $post->user_id = 1;
        $post->author = 'Nahid Ferdous';
        $post->description = '<p><strong>Boro growers suffer crop loss in heat shocks; now they worry over flash floods, hailstorms and rice import during harvesting season</strong></p><p>Amidst growing worries over a heat wave-induced crop loss and projections of flash floods and nor’westers, Boro farmers are still unsure what price offer they’re going to get from the government this year.</p><p>Continuous imports of rice from abroad during the peak domestic harvesting season also adds to the worries.</p><p>Ideally,&nbsp;the&nbsp;Food Planning and Monitoring Committee (FPMC) – a cabinet body&nbsp;comprising&nbsp;eight ministers –&nbsp;meets in early April to take stock of the&nbsp;food reserve situation, crop situation in the field and set prices and targets&nbsp;for the procurement of&nbsp;Boro paddy, rice and wheat&nbsp;from farmers.</p><p>This early indication from the government is considered crucial for the farmers, who invest heavily in the irrigated rice Boro, premier among the three rice seasons in Bangladesh. But this year, farmers who have already suffered some crop losses owing to heat shocks, haven’t had any indication of a price incentive &nbsp;yet.</p><p>When asked, food ministry officials involved in the process told Dhaka Tribune on Saturday that the ministers couldn’t meet for the FPMC meeting over the last two weeks. “We’re planning to hold it in a day or two, if needed virtually, amidst the nationwide lockdown,” said an official asking not to be named.</p><p>The government bought only over 80,000 tons of rice against a target purchase of 800,000 tons from the farmers in the last rice season – Aman. Now, Boro growers are looking forward to a government announcement on how much rice and at what price it will buy from farmers in the Boro procurement season. &nbsp;</p><p>Farmers are also worried about continuous imports of cheaper rice from across the border during the peak domestic harvesting season. Over the past four months more than eight lakh tons of rice have been imported by the food department and also by private traders, with three lakh tons more being in the import pipeline.&nbsp;</p><p>Initially, the government initiated the import move to replenish its poor grain stock and control the high market price of rice. But it went into the international market very late into the season, resulting in a flooding of the local market with imported rice during the peak Boro season, which farmers fear may have dampened the current market price.</p><p>------------------------------------------------</p><p><strong>Also Read - </strong><a href="https://www.dhakatribune.com/bangladesh/agriculture/2021/03/11/farmers-in-trouble-without-water-management-facilities-in-khulna"><strong>Farmers in trouble without water management facilities in Khulna</strong></a></p><p><strong>-----------------------------------------------</strong></p><p>Earlier this month, a heat wave struck standing paddy in over 50,000 hectares of Boro fields in more than 12 districts, causing up to two lakh tons of probable crop loss. Officials say that once a full assessment is done across the country, the loss figure would most likely much be higher as high temperature and mild heat waves are still persisting in many other rice growing regions. &nbsp;</p><p>Meanwhile, the Flood Forecasting and Warning Centre (FFWC) of the Bangladesh Water Development Board has made projections of probable flash floods sometime at the end of April.</p><p>FFWC spokesperson Md Arifuzzaman Bhuiyan told Dhaka Tribune on Saturday that the centre had already advised all agriculture departments concerned to make sure farmers in Haor region harvested Boro paddy – even if 80 percent is ripened – before the onset of flash floods.&nbsp;</p><p>“There is news of rainfall upstream [in Northeast Indian] and if the volume increases in the coming weeks, it may trigger flash floods in our Haor zone,” said Bhuiyan.</p><p>Meanwhile, the government’s capacity to intervene and rein in high rice prices has been handicapped by its poor stock. The Food Ministry says that till this week the government has only 3.7 lakh tons of rice in public granaries. This stock volume is much less than usual for this period of the year.</p><p>Amidst the lockdown-induced financial hardship among lower-income bracket people, the government is heavily banking on cash dole-outs instead of food assistance.&nbsp;</p><p>Analysts say if&nbsp;the government now offers a&nbsp;good purchase price and&nbsp;procures&nbsp;a big volume of Boro directly from the farmers –&nbsp;instead of from&nbsp;rice millers and middlemen –&nbsp;it will help it replenish&nbsp;the dwindling stock, halt rice import and well compensate farmers’ high investments in Boro.</p><p>The Agriculture Ministry is expecting over 20 million tons of Boro rice this year from 4.8 million hectares planted.</p><p>During last year’s Boro season, the government had announced a purchase of around two million tons of paddy and rice but eventually bought only half the amount.</p>';
        $post->save();
        foreach ([2] as $categoryId) {
            $post->postCategory()->attach($categoryId);
        }
        try {
            $file1 = 'https://media-eng.dhakatribune.com/uploads/2021/01/unnamed-1611515006286.jpg';
            $file2 = 'https://media-eng.dhakatribune.com/uploads/2021/04/food-info-edit-1618674941507.jpg';
            $post->addMediaFromUrl($file1)->toMediaCollection('posts');
            $post->addMediaFromUrl($file2)->toMediaCollection('posts');
        } catch (DiskDoesNotExist | FileDoesNotExist | FileIsTooBig $e) {
            return response()->json(['error', $e], 500);
        }


        # Post 3 #:------------------------------------------------------------
        $post = new Post();
        $post->title = 'Over 4 L tons of wheat produced in Rajshahi division.';
        $post->slug = 'over-4-l-tons-of-wheat-produced-in-rajshahi-division';
        $post->type = 'news';
        $post->status = true;
        $post->user_id = 1;
        $post->author = 'Nahid Ferdous';
        $post->description = '<p><strong>The farmers got the wheat yield from about 1.32 lakh hectares of land in all eight districts under the division during the recent past harvesting season</strong></p><p>Farmers have harvested around 4.81 lakh tons of wheat in Rajshahi division supplementing the government efforts of ensuring food security amid the present adverse impact of Covid-19 pandemic.</p><p>The farmers got the wheat yield from about 1.32 lakh hectares of land in all eight districts under the division during the recent past harvesting season.</p><p>According to the official sources of the Department of Agriculture Extension (DAE), the growers were seen delighted while they got good yield as a result of favourable climatic conditions in the region, including its vast Barind tract.</p><p>This season, they are also getting a fair price of their production in the present pandemic situation.</p><p>Muktar Ali, 42, a farmer of Hatibandha village under Godagari upazila, had cultivated wheat on three bighas of land and got 14 mounds of yield from per bigha of land.</p><p>He is happy over the obtained yield. He said many of his co-villagers have harvested 14 to 16 mounds of wheat and most of them are happy over this year’s yield as they cultivated high-yielding varieties.</p><p>Ali continued that many farmers are getting three to four mounds more wheat from per bigha of land this season in comparison to the previous season.</p><p>“Acreage of wheat farming has been enhanced to a greater extent in the Barind area in recent years as the farmers are getting profit from the food grain farming,” said Atanu Sarker, sub-assistant agriculture officer.</p><p>He said timely sowing of seeds accompanied by the cold spell, has been considered as a positive sign for attaining a bumper production of the cash crop.</p><p>The DAE has disbursed seeds and fertilizers free of cost among 36,500 flood-affected farmers for wheat farming under the government’s ‘Agricultural Incentive Programme’ so that they can recoup their losses caused by the flood in the division, said Sirajul Islam, additional director of the DAE.</p><p>Besides, the department has distributed seeds and fertilizers free of cost among 23,000 other poor and marginal farmers for wheat farming under the government’s ‘Agricultural Incentive Programme’ in the division.</p><p>Rajshahi Regional Office of Bangladesh Wheat and Maize Research Institute (BWMRI) had developed 320 demonstration plots on farmers’ fields.</p><p>Dr Ilias Hossain, principal scientific officer of BWMRI said they are promoting some high yielding, heat and drought tolerant and blast disease resistant varieties like Barigom 28, 29, 30 and 33 among the farmers.</p><p>The Barigom 33 is the ever latest variety which is blast disease resistant, zinc-enriched, large grain size and high yielding (20 maunds per bigha), he added.</p><p>Various other government and non-government entities adopted diversified steps to make farming a total success in the region as it is suitable for the crop for its water-saving and drought tolerant features.</p><p>Barind Multipurpose Development Authority (BMDA), an ever-largest irrigation providing state-run organisation in the country’s northwest region, has ensured necessary irrigation to make the wheat farming a total success.</p><p>More than 12.58 lakh community people of 2.66 lakh households are being motivated towards promoting wheat like water-saving crops with intervention of the ‘Integrated Water Resource Management (IWRM)’ Project.</p><p>The project is being implemented by DASCOH Foundation in around 1,280 drought-hit villages under 39 union Parishads (UPs) and three municipalities of eight upazilas in Rajshahi, Naogaon and Chapainawabganj districts since 2015, said Jahangir Alam Khan, coordinator of IWRM Project.</p><p>He, however, said successful promotion of less-water consuming crops in the Barind area would play a vital role to lessen the gradually mounting pressure on its underground water.</p>';
        $post->save();
        foreach ([2] as $categoryId) {
            $post->postCategory()->attach($categoryId);
        }
        try {
            $file1 = 'https://media-eng.dhakatribune.com/uploads/2021/04/over-4-l-tons-of-wheat-produced-in-rajshahi-division-1618652963135.jpg';
            $post->addMediaFromUrl($file1)->toMediaCollection('posts');
        } catch (DiskDoesNotExist | FileDoesNotExist | FileIsTooBig $e) {
            return response()->json(['error', $e], 500);
        }


        # Post 4 #:------------------------------------------------------------
        $post = new Post();
        $post->title = 'Thai guava cultivation method.';
        $post->slug = 'thai-guava-cultivation-method';
        $post->type = 'farming-practice';
        $post->status = true;
        $post->user_id = 1;
        $post->author = 'Nahid Ferdous';
        $post->description = '<p>Like other varieties of guava, Thai guava-6 seedlings can be planted till the month of Jaish - Ashwin. Drained sandy loam soil is best for cultivating this guava. Seedlings or cocoon cuttings from seeds should be used for breeding. Guava seedlings of this variety are to be planted at a distance of 4x4 or 3x3 m. A few weeks before planting, a hole 50 cm long, 50 cm wide and 50 cm wide should be dug. 20 to 30 days before planting the seedlings in each hole should be mixed with 40 to 50 kg of decomposed dung manure, 150 g TSP and 150 g MOP fertilizer. Then fill the hole with soil mixed with manure and plant the seedling right in the middle of the hole. After planting the seedlings should be tied high around the hole with soil so that the outside water does not accumulate at the base of the tree. The tree should be lightly tied with bamboo poles so that it does not fall in the wind. If there is lack of sap in the soil, irrigation should be arranged.</p><p>In order to get higher yield from guava tree, 20 to 25 kg of decomposed dung per year, 300 to 400 g of urea, 300 to 400 g of TSP and 300 to 400 g of MOP and 25 to 30 kg of decomposed dung per year for each plant above five years of age. , Urea 500 to 600 g, TSP 450 to 550 g, MOP 450 to 550 g fertilizer should be used. The mentioned amount of fertilizer should be divided into two equal parts and applied in two installments in February-March and August-September of the year. Irrigation should be given if necessary after application of fertilizer. Zinc deficiency often causes chlorosis in the leaf veins. In that case 400 grams of zinc and 400 grams of lime should be mixed in 60 liters of water and sprayed on the plant After collecting guava, broken, diseased and dead branches should be pruned. Guava trees bear a large number of fruits every year. It is not possible for a tree to bear all the fruits. Therefore, if the shape is marble, the densely packed fruit should be pruned. It is better not to keep too much fruit on the tree in summer or rainy season. Since this variety of guava bears fruit throughout the year, the farmer will benefit more if the winter yield is good.</p>';
        $post->save();
        foreach ([1, 7] as $categoryId) {
            $post->postCategory()->attach($categoryId);
        }
        try {
            $file1 = 'https://farm4.staticflickr.com/3886/15144922569_c7c1070004_b.jpg';
            $file2 = 'https://images.offerup.com/A63qhyzoYQ253ERkO-e0SmUxu3Q=/600x448/555b/555bc19c1be44e22b46f505164fda025.jpg';
            $post->addMediaFromUrl($file1)->toMediaCollection('posts');
            $post->addMediaFromUrl($file2)->toMediaCollection('posts');
        } catch (DiskDoesNotExist | FileDoesNotExist | FileIsTooBig $e) {
            return response()->json(['error', $e], 500);
        }


        # Post 5 #:------------------------------------------------------------
        $post = new Post();
        $post->title = 'Bumper pumpkin output helps char people tackling coronavirus situation.';
        $post->slug = 'thod';
        $post->type = 'news';
        $post->status = true;
        $post->user_id = 1;
        $post->author = 'Nahid Ferdous';
        $post->description = '<p><strong>Braving the Covid-19 pandemic situation, char people have cultivated pumpkin with other Rabi crops on char lands adopting intercropping and mixed relay methods this time to reap pleasing profits as harvest of the crop is nearing completion now</strong></p><p>Many char people are happy getting bumper output of pumpkin with lucrative price this season to tackle the coronavirus (Covid-19) pandemic situation in Rangpur agriculture region.</p><p>Officials of the Department of Agricultural Extension (DAE) and different NGOs said large-scale cultivation of pumpkin began on sandy char lands in the silted-up beds of different rivers in all five districts of the region since 2009.</p><p>Braving the Covid-19 pandemic situation, char people have cultivated pumpkin with other Rabi crops on char lands adopting intercropping and mixed relay methods this time to reap pleasing profits as harvest of the crop is nearing completion now.</p><p>The DAE, Bangladesh Agriculture Research Institution (BARI), RDRS Bangladesh and other non-governmental organisations extended assistance to char people to promote cultivation of various crops, including pumpkin, on char lands.</p><p>Additional Director of the DAE for Rangpur region Agriculturist Khandker Abdul Wahed said cultivation of pumpkin with other crops on char lands is efficiently cutting poverty and improving livelihoods of many char people in recent years.</p><p>Adapting to natural disasters like floods and river erosion, many char and riverside people have achieved self-reliance by cultivating pumpkins with other crops using intercropping methods on char lands in the last 12 years across the region.</p><p>“Putting maximum efforts on ensuring best use of char lands, the DAE provided support and technologies to people living in char areas to increase crop output for improving their livelihoods and attaining food security amid changing climate,” he said</p><p>As the farming cost of pumpkins is low, char people have cultivated pumpkins on more char lands and silted-up beds of the Teesta, Brahmaputra, Jamuna, Dharla, Kartoa, Ghaghot and other rivers to complete harvest of the crops by May next.</p><p>Senior Coordinator (Agriculture and Environment) of RDRS Bangladesh Agriculturist Mamunur Rashid said &nbsp;around 55,000 char families have so far changed fortunes through farming pumpkins with other crops on char lands in the region.</p><p>“As harvest of pumpkins is nearing completion, char people are selling every piece of pumpkins at rates between Tk 40 and 70 depending on size and varieties to wholesalers and middlemen to reap better profits and lead a better life,” he said.</p><p>Farmers Mofizul Haque, Fazlul Haque and Amena Begum of Char Dakshin Balapara Kutirpar village in Aditmari upazila of Lalmonirhat said they have achieved self-reliance through pumpkin farming on char lands.</p><p>“A farmer generally spends Tk a 1,500 for cultivating pumpkin on 120 sandbars and sells 500 pieces of pumpkin at Tk 18,000 on an average to earn a net profit of Tk 17,000 each,” said farmer Mofizul Haque.</p><p>Char farmers Abdur Razzaque, Kochhim Uddin, Morsheda Begum and Mahbub Alam of village Char Paschim Mohipur in Gangachara upazila of Rangpur also narrated their success stories of winning poverty and attaining self-reliance through pumpkin cultivation.</p><p>They had cultivated pumpkins on 150 sandbars on an average each on the Teesta riverbed and earned net profits of Tk 26,000 each after completing harvest last week.</p>';
        $post->save();
        foreach ([1, 7] as $categoryId) {
            $post->postCategory()->attach($categoryId);
        }
        try {
            $file1 = 'https://media-eng.dhakatribune.com/uploads/2021/04/bumper-pumpkin-output-helps-char-people-tackling-coronavirus-situation-1618215592352.jpg';
            $post->addMediaFromUrl($file1)->toMediaCollection('posts');
        } catch (DiskDoesNotExist | FileDoesNotExist | FileIsTooBig $e) {
            return response()->json(['error', $e], 500);
        }

        # Post 6 #:------------------------------------------------------------
        $post = new Post();
        $post->title = 'Mango production should be done throughout the year.';
        $post->slug = 'mango-production-should-be-done-throughout-the-year';
        $post->type = 'blog';
        $post->status = true;
        $post->user_id = 1;
        $post->author = 'Nahid Ferdous';
        $post->description = '<p>আম বাংলাদেশে একটি বাণিজ্যিক ফল। অধিক ফলন ও গুণগতমানসম্পন্ন আম উৎপাদনের জন্য নিম্নলিখিত কার্যক্রমসমূহ বাস্তবায়ন করা প্রয়োজন:</p><p><strong>মুকুল</strong> <strong>আসার</strong> <strong>পর (জানুয়ারি - মার্চ)</strong></p><ul><li>মুকুল বের হওয়ার পর কিন্তু ফুল ফোটার আগে হপার পোকা দমনে অনুমোদিত কীটনাশক ও অ্যানথ্রাকনোজ রোগ দমনে অনুমোদিত ছত্রাকনাশক একত্রে মিশিয়ে প্রথমবার ও এক মাস পর দ্বিতীয়বার স্প্রে করতে হবে।</li><li>ফুল সম্পূর্ণ ফোটার পর থেকে শুরু করে ১৫ দিন পর পর ৪ বার পরিবর্তিত বেসিন পদ্ধতিতে সেচ দিতে হবে। এ সময় বৃষ্টি হলে মাটির আর্দ্রতা বুঝে সেচ দিতে হবে।</li></ul><p><strong>ফল</strong> <strong>ধারণের</strong> <strong>পর (ফেব্রুয়ারি</strong> - <strong>মে)</strong></p><ul><li>আমের আকার মটরদানার মতো হলে অবশিষ্ট অর্ধেক ইউরিয়া ও এমওপি সার সমান দুইভাগে ভাগ করে এক ভাগ প্রয়োগ করতে হবে ।অবশিষ্ট সার এপ্রিলের শেষ সপ্তাহ থেকে মে মাসের প্রথম সপ্তাহের মধ্যে প্রয়োগ করতে হবে।</li><li>ফল ঝরা রোধে প্রতি লিটার পানিতে ২০ গ্রাম ইউরিয়া মিশিয়ে ফল মটরদানা অবস্থায় একবার এবং মার্বেল আকৃতির হলে দ্বিতীয় বার স্প্রে করতে হবে।</li><li>প্রাথমিক পর্যায়ে আমের উইভিল ও ফলছিদ্রকারী পোকা দমনের জন্য অনুমোদিত কীটনাশক মধ্য মার্চ হতে ১৫ দিন পর পর ২/৩ বার স্প্রে করতে হবে। পরিপক্বতার সময় মাছি পোকা দমনের জন্য ফল সংগ্রহের এক মাস পূর্বে সেক্স ফেরোমন ফাঁদ বা ব্যাগিং পদ্ধতি ব্যবহার করতে হবে ।</li></ul><p><strong>ফল</strong> <strong>সংগ্রহ (মে - সেপ্টেম্বর)</strong></p><ul><li>আম পরিপক্ক হলে গাছ থেকে এমনভাবে পাড়তে হবে যেন কোনো আঘাত না লাগে।</li><li>অল্প (১ - ২ ইঞ্চি) বোটাসহ আম সংগ্রহ করতে হবে এবং আম কিছুক্ষণ উপুড় করে আঠা ঝরিয়ে নিতে হবে।</li><li>আম পাড়ার ১৫/২০ দিন পূর্বে আম গাছে কোনো প্রকার কীটনাশক বা ছত্রাকনাশক স্প্রে করা যাবে না।</li><li>আম পাড়ার পর ৫৫ ডিগ্রি সে. তাপমাত্রার গরম পানিতে ৫ মিনিট ডুবিয়ে ছায়াযুক্ত স্থানে শুকিয়ে নিতে।</li></ul><p><strong>মুকুল</strong> <strong>আসার</strong> <strong>আগে (জুন - ডিসেম্বর)</strong></p><ul><li>বর্ষার শেষে এবং ফল সংগ্রহের পর গাছের শুকনো, মরা, রোগাক্রান্ত ও দুর্বল ডালপালা ও পরগাছা কেটে গাছ পরিষ্কার করতে হবে এবং সে স্থানে বোর্দো পেস্ট বা কপার জাতীয় ছত্রাকনাশকের প্রলেপ দিতে হবে।</li><li>সেপ্টেম্বর মাসের ১৫ - ৩০ তারিখের মধ্যে গাছের বয়স অনুসারে নির্ধারিত মাত্রায় প্রথম কিস্তির সার (জৈবসার, টি এসপি, জিপসাম, জিংক সালফেট এবং বরিক এসিডের সম্পূর্ণ এবং ইউরিয়া ও এমওপি সারের অর্ধেক পরিমাণ) প্রয়োগ করতে হবে।</li><li>গাছের গোড়া হতে কমপক্ষে ১ - ১ .৫ মিটার বাদ দিয়ে দুপুর বেলা যে পর্যন্ত ছায়া পড়ে সে স্থানে সার ছিটিয়ে হালকাভাবে কুপিয়ে মাটির সাথে মিশিয়ে দিয়ে একটি হালকা সেচ দিতে হবে।</li><li>অক্টোবর মাস হতে ফল আসার আগ পর্যন্ত গাছে সার ও সেচ দেয়া যাবে না। এ সময় গাছের গোড়া আগাছা মুক্ত রাখতে হবে।</li></ul>';
        $post->save();
        foreach ([1, 7] as $categoryId) {
            $post->postCategory()->attach($categoryId);
        }
        try {
            $file1 = 'https://images.financialexpress.com/2019/04/mango-1.jpg';
            $post->addMediaFromUrl($file1)->toMediaCollection('posts');
            $file2 = 'https://images.outlookindia.com/public/uploads/articles/2019/6/1/mango.jpg';
            $post->addMediaFromUrl($file2)->toMediaCollection('posts');
        } catch (DiskDoesNotExist | FileDoesNotExist | FileIsTooBig $e) {
            return response()->json(['error', $e], 500);
        }

        # Post 7 #:------------------------------------------------------------
        $post = new Post();
        $post->title = 'Bangladesh farmers need bailout to recover from heatwave-induced crop loss.';
        $post->slug = 'bangladesh-farmers-need-bailout-to-recover-from-heatwave-induced-crop-loss';
        $post->type = 'news';
        $post->status = true;
        $post->user_id = 1;
        $post->author = 'Nahid Ferdous';
        $post->description = '<p>Primary estimates show probable loss of 200,000 tons of Boro rice in over 50,000 hectares of land&nbsp;</p><p>A week after a heatwave swept through parts of Bangladesh’s rice-growing belts, a much clearer picture of crop damages has emerged with agriculture officials asking the government to arrange for an immediate bailout for the affected farmers.</p><p>Officials told Dhaka Tribune on Monday that a primary estimate sums up a substantial crop loss in over 50,000 hectares of Boro land due to spikelet sterility in rice caused by a heatwave that swept through several districts including some parts of the Haor region on April 4.</p><p>Farmers may lose 100,000 to 200,000 tons of rice – in the most conservative estimate – depending on how many recoup mechanisms the government provides them. In the current market price, 200,000 tons of rice costs around Tk 700 crore.</p><p>Though an estimated loss of 200,000 tons of rice would be just 1% of the total expected output of 20 million tons in Boro this year, scientists and agriculture officials fear more paddy fields likely to experience spikelet sterility due to very high temperatures persisting in the country.&nbsp;</p><p>A senior agriculture official told the newspaper that farmers in worst-hit Netrakona said they were unlikely to harvest Boro paddy from lands, where 40% to 50% or more rice spikelet has gone sterile unless the government provides them with assistance.</p><p>Officials at the Ministry of Agriculture (MoA), however, are yet to figure out how best the government can provide the assistance.</p><p>Some officials said they received recommendations from the field officials that farmers want the government to deploy combined harvesters, free of cost, in affected areas to reap the remnants of the yield.</p><p>Otherwise, it wouldn’t be cost-effective for individual farmers to bear the costs of harvesting for reaping just a partial crop.</p><p>Besides, farmers and district agriculture offices also pleaded to MoA for providing cash assistance to farmers, particularly the landless sharecroppers, who are now at loss after investing a lot in Boro rice.</p><p>Department of Agricultural Extension (DAE) Director General Md Asadullah had earlier said that Boro acreage increased from last year’s 4.7 million hectares to 4.8 million hectares this year as farmers were eyeing a good profit amidst buoyant rice price in the market.</p><p>Bangladesh Rice Research Institute’s (BRRI) scientist Dr Nazmul Bari, who led a three-strong team’s visit to some of the most affected Upazilas in Netrakona on April 6, told Dhaka Tribune that increased acreage may well compensate the heatwave-induced loss and may not impact that much in national level overall Boro output but, the farmers who lost their crops are badly in need of help.</p><p>Dr Bari said, at primary estimate, the April 4 heatwave has damaged 35% of Boro crop in Madan, over 20% in Kendua and 15% in Khaliajuri upazilas in Netrakona.</p><p>Rice fields in Sherpur, Mymensingh, Sunamganj, Rajshahi, Gopalganj and many other pockets were also affected by the heatwave, which was followed by some rainfalls too, he said.</p><p>“But in Netrakona, it was a couple of hours of strong hot gusty wind that severely damaged the grain formation of the Boro rice plants. There was no rainfall afterwards in Netrakona that day further aggravating the condition,” he explained.</p><p>“If night temperature falls below 17 degrees Celsius or day temperate rises above 35 degrees Celsius during Boro season, the rice grains milk formation gets severely affected. Comparing to last year’s 31 degrees Celsius temperature, Netrakona experienced 38 degrees same time this year,” said Dr Bari.</p><p>He recalled some records of previous heatwaves-induced crop losses in 1996, 2012 but said this year’s one was in greater magnitude. He said he wouldn’t be surprised if in the final count the heat-induced Boro crop loss reaches 5% of total expected output.</p><p>Agriculturalists, meanwhile, also cautioned against infestation of brown planthopper and bacterial leaf blight in Boro fields in the aftermath of the strong heatwave and some of the subsequent mild heatwaves. They urged for keeping the farm input marketing and distribution channels uninterrupted during the hard lockdown from April 14. &nbsp;&nbsp;</p><p>According to a Met Office bulletin during the filing of this report, there was a projection of mild heat wave sweeping over some parts of Khulna division and the regions of Rangamati, Feni, Rajshahi, Pabna, Naogaon, Dinajpur, Nilphamari and Panchagarh.</p><p>DAE’s Plant Protection Wing Director Dr Md Abu Sayeed Miah recently issued a crop management special directive asking Boro farmers to protect Boro from brown planthoppers by deploying light traps and also for applying required doses of pesticides, fungicides.</p><p>The current issue of the National Agrometeorological Advisory Service Bulletin advised farmers to stop applying urea in Boro land if the fields are attacked by bacterial leaf blight and irrigate and maintain a certain water level in the Boro fields.</p><p>“Irrigation management should be followed by periodic wetting and drying (AWD) method to control bacterial leaf blight,” recommended the bulletin jointly issued by Bangladesh Meteorological Department and DAE’s Bangladesh Agro-Meteorological Information Portal (BAMIS).</p><p>Harvested during the April-May period, Boro rice accounts for 55% of Bangladesh’s total yearly rice output of 36 million tons. The two other rice seasons are Aman and Aus.</p>';
        $post->save();
        foreach ([19] as $categoryId) {
            $post->postCategory()->attach($categoryId);
        }
        try {
            $file1 = 'https://media-eng.dhakatribune.com/uploads/2021/01/boro-cultivation-on-in-full-swing-in-barind-tract-as-growers-ignore-biting-cold-1612096146511.jpg';
            $post->addMediaFromUrl($file1)->toMediaCollection('posts');
        } catch (DiskDoesNotExist | FileDoesNotExist | FileIsTooBig $e) {
            return response()->json(['error', $e], 500);
        }

        # Post 8 #:------------------------------------------------------------
        $post = new Post();
        $post->title = 'Farming for the future.';
        $post->slug = 'farming-for-the-future';
        $post->type = 'farming-practice';
        $post->status = true;
        $post->user_id = 5;
        $post->author = 'Officer Nahid';
        $post->description = '<p>We must look into alternatives that require less space but a more efficient way to produce vegetables and fruits</p><p>Last year I had an opportunity to feature an organization (Green Savers), that worked with providing a sustainable solution for growing food, especially for the urban population. With an ever-growing number of inhabitants in the major metropolitans and a decreasing number of open spaces for cultivation, given that any piece of land is very expensive to be used for farming. We must look into alternatives that require less space but a more efficient way to produce vegetables and fruits.</p><p>Urban farming these days has acquired several upgrades as more people are getting interested in it. With agriculture being the heart of Bangladesh’s economy, millions of people around the country are engaged in this sector, but it’s far from having an efficient supply chain as crops, vegetables and livestock become extremely expensive by the time they get to the markets around the major cities. For example, a litre of raw milk in Chandpur costs around Tk 55 to Tk 60, in Dhaka it varies from Tk 80 to Tk 100. It’s because farms around the cities have to spend extra on cattle feed and the scarce land means, there is very little to no space to grow grass. The grass is especially more important for dairy cows as milk yields largely depend on it.</p>' .
            '<iframe width="560" height="315" src="https://www.youtube.com/embed/GTtjXXtiy7g" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>' .
            '<p>Across Bangladesh, there is a rising number of modern dairy and cattle farmers who are adopting new ways to produce fodder that are way more efficient and reliable. Hydroponic farming provides that perfect solution. The main principles of hydroponics are increased oxygen to the root zone, and liquid feed delivered directly to roots. These factors result in increased growth rates, and increased yields when compared to traditional soil gardens where much lower oxygen and often nutrient levels are present. This method enables farmers to expand production vertically, reducing dependency on soil and from using up too much space, which is financially more feasible.</p><p>As I mentioned urban farming going up a few notches, it is quite literally so. Vertical expansion of farming isn’t only limited to growing fodder, vegetables or fruits. A few are trying to raise livestock in a similar manner as well. Last month Shykh Seraj wrote an article on the Daily Star regarding this, where a man named Zakir Hossain has done the most unexpected, running a full-fledged cattle farm in a multi-storied building. Producing 300 litres of milk every day apart from an additional section for beef fattening, which is next to impossible to achieve in a small space of only four kathas. The entire production is taking place in the capital’s Jatrabari area, a living proof of the possibilities of vertical farming.</p><p>However, there are a few challenges, one being associated with the cost for such set-ups. A hydroponic fodder system can set a farmer back between Tk 1.5-3 lacs, even more, depending on the size and capacity of the setup. The availability of technology is another major issue as there are simply not enough experts to accommodate everyone. Green Savers Association is an organization working with projects like this, but more such institutions need to come forward with their expertise to train the farmers and share their knowledge of the benefits of growing produce vertically.&nbsp;</p>';
        $post->save();
        foreach ([1] as $categoryId) {
            $post->postCategory()->attach($categoryId);
        }
        try {
            $file1 = 'https://wartalaap.com/wp-content/uploads/2020/01/Vertical-Farming-An-Innovation-in-Agricultural-Industries5.jpg';
            $post->addMediaFromUrl($file1)->toMediaCollection('posts');
            $file2 = 'https://commercialwaste.trade/wp-content/uploads/2019/07/featured-image-of-vertical-farming.jpg';
            $post->addMediaFromUrl($file2)->toMediaCollection('posts');
        } catch (DiskDoesNotExist | FileDoesNotExist | FileIsTooBig $e) {
            return response()->json(['error', $e], 500);
        }

        # Post 9 #:------------------------------------------------------------
        $post = new Post();
        $post->title = 'Breeders developing doubly resistant brinjal varieties.';
        $post->slug = 'breeders-developing-doubly-resistant-brinjal-varieties';
        $post->type = 'news';
        $post->status = true;
        $post->user_id = 1;
        $post->author = 'Nahid Ferdous';
        $post->description = '<p>Fruit and shoot borer-resistant Bt brinjal reaches out to 65,000 farmers in 7 years, work underway to achieve bacterial wilt resistance &nbsp;</p><p>Starting with only 20 farmers in 2014, the technology of Bt brinjal – a crop developed to drastically lower hazardous pesticide application – reached to 65,000 eggplant growers this year, making it the fastest expanding biotech product in Bangladesh.</p><p>Bt brinjal, a genetically modified eggplant variety, was developed to fight fruit and shoot borer (FSB) that used to cause colossal crop loss in Bangladesh’s brinjal fields but not anymore.</p><p>Now, riding on the huge success of Bangladesh’s fastest expanding biotech crop, breeders areworking on developing two new eggplant varieties capable to withstand FSB and bacterial wilt.</p><p>Together with FSB, the bacterial wilt causes substantial crop loss in brinjal, second most consumed vegetable in Bangladesh after potato.</p><p>Dr Yousuf Akhond, a chief scientific officer of Bangladesh Agricultural Research Institute (Bari) who heads the institution’s biotechnology division, told Dhaka Tribune recently that by working on two previously released brinjal varieties – Bari Begun-10 and Bari Begun-11 – they are now developing varieties, expected to withstand bacterial wilt.</p><p>Once success comes Bari’s way, brinjal breeders hope farmers in Bangladesh would get varieties of eggplants, which would effectively withstand both FSB and bacterial wilt.</p><p>Till date, Bangladesh is only country in South Asia to release GM food crop while some of its neighbours i.e., India, Pakistan have long been cultivating Bt cotton, a cash crop. &nbsp;&nbsp;</p><p>Bt brinjal controls the FSB without the need for pesticide sprays to control it, thereby cutting farmers’ investment cost on brinjal and also resolving the worry over pesticide-induced health hazards. A few sprays are still needed to control insects like thrips, aphids and other minor insects that are not susceptible to the Bt protein produced by the plant.</p><p>However, bacterial wilt disease which lingers in many of the soils in Bangladesh, is not controllable by any sprays. Bacterial wilt is best controlled by using plants that are resistant to the disease.</p><p>Dr Md Jahangir Hossain, who coordinates biotech brinjal and late blight-resistant potato project in Bangladesh, told this correspondent that in 2020-21 crop year as many as 65,000 farmers in Bangladesh are growing Bt brinjal in 12,500 acres of land.</p><p>Fast adoption of Bt brinjal, he said, helped farmers reap double benefits of cost cutting and much less application of chemical pesticides.</p><p>Each year Bangladeshi farmers grow over half a million tons of brinjal from over 50,000 hectares of land. But scientists hope further adoption of Bt brinjal and future release of bacterial blight-resistant varieties would help farmers grow more brinjals from less land. &nbsp;&nbsp;</p><p>Earlier, five years after introducing country’s first genetically modified crop – Bt brinjal – government undertook an impact assessment study in 2018. It stated that the farmers got benefitted financially by cultivating Bt brinjal and they are now less prone to health hazards caused by pesticide sprays.&nbsp;</p><p>Under the Ministry of Agriculture’s behest, the study on 1200 farmers was designed and carried out by the International Food Policy Research Institute (IFPRI).&nbsp;</p><p>The study outcome found that the farmers who cultivated the Bt brinjal gained by 55 percent higher income comparing to their peers growing the non-Bt brinjal.&nbsp;</p><p>The genetically modified Bt brinjal has been developed by inserting a crystal protein gene (Cry1Ac) from the soil bacterium <i>Bacillus thuringiensis</i> into the genome of various brinjal cultivars thereby, protecting the crop from infestation of Fruit and Shoot Borer (FSB), the deadliest pest for brinjal.</p><p>There is an array of other biotech crop products now under release and development pipeline in Bangladesh which include, among others, Vitamin-A enriched Golden Rice, bacterial blight resistant potato, leafcurl resistant tomato, and Bt cotton.</p>';
        $post->save();
        foreach ([19] as $categoryId) {
            $post->postCategory()->attach($categoryId);
        }
        try {
            $file1 = 'https://media-eng.dhakatribune.com/uploads/2021/04/untitled-1617729640416.jpg';
            $post->addMediaFromUrl($file1)->toMediaCollection('posts');
        } catch (DiskDoesNotExist | FileDoesNotExist | FileIsTooBig $e) {
            return response()->json(['error', $e], 500);
        }

        # Post 10 #:------------------------------------------------------------
        $post = new Post();
        $post->title = 'Requirements for zinc rich rice.';
        $post->slug = 'requirements-for-zinc-rich-rice';
        $post->type = 'blog';
        $post->status = true;
        $post->user_id = 1;
        $post->author = 'Nahid Ferdous';
        $post->description = '<p><strong>জিংক সমৃদ্ধ ধানের প্রয়োজনীয়তা</strong></p><p>বাংলাদেশ খাদ্য নিরাপত্তা অর্জনে সফল হলেও পুষ্টি নিরাপত্তায় রয়েছে ব্যাপক ঘাটতি। পুষ্টি নিরাপত্তা নিশ্চিতকরণে সরকার&nbsp; তার জাতীয় পুষ্টি প্রগ্রামের অধীনে ভিটামিন এ ট্যাবলেট খাওয়ানোর মাধ্যমে ঘাটতি পুরন করার চেষ্টা অব্যাহত রেখেছে। ভিটামিন এ ছাড়াও মানবদেহ গঠনের একটি অতীব গুরুত্বপূর্ণ অণুপুষ্টি উপাদান হল জিংক।</p><p>বাংলাদেশে হারভেস্টপ্লাস প্রোগ্রামের উদ্দেশ্য জিংক বা দস্তা সমৃদ্ধ উচ্চ ফলনশীল ধানের জাত উদ্ভাবন, অবমুক্তকরন, ক্ষুদ্র ও প্রান্তিক চাষিদের মাঝে এ সকল জাতের গ্রহণযোগ্যতা বাড়ানো এবং জিংক সমৃদ্ধ চাল খেতে উদ্বুদ্ধকরনের মাধ্যমে নারী ও শিশুদের জিংক ঘাটতি দূরীকরণ।</p><p><strong>মানব দেহে জিংকের প্রয়োজনীয়তা</strong></p><p>v&nbsp; জিংক সমৃদ্ধ খাবার খেলে ছেলে মেয়েরা খাটো হয় না।</p><p>v&nbsp; শিশুদের শারীরিক বৃদ্ধি ও মেধার বিকাশ হয়। ক্ষুধা মন্দা দূর করে।</p><p>v&nbsp; রোগ প্রতিরোধ ক্ষমতা বাড়ায়।</p><p>v&nbsp; কিশোরী মেয়ে ও গর্ভবতী মায়ের জিংকের অভাব হলে শারীরিক দুর্বলতা দেখা দেয় এবং গর্ভের বাচ্চার স্নায়ুতন্ত্র ক্ষতিগ্রস্থ হয়।</p><p>v&nbsp; দৈনিক শিশুদের ৩-৫ মিলিগ্রাম ও মহিলাদের ৮-৯ মিলিগ্রাম জিংকের প্রয়োজন।</p><p>&nbsp;</p><p>মানব দেহের একটি অত্যাবশ্যকীয় অনুপুষ্টি হল জিংক। বাংলাদেশে পাঁচ বছরের কম বয়সে শতকরা ৪৪ ভাগ শিশু এবং ৫৭ ভাগ মহিলারা জিংকের অভাবে ভুগছে। ১৫-১৯ বছরের শতকরা ৪৪ ভাগ মেয়েরা এর অভাবে খাটো হয়ে যাচ্ছে। এর সমাধান খুজতে গিয়ে (বায়োফটিফিকেশন এর মাধ্যমে) আমাদের প্রধান খাদ্য ভাত এর মধ্যে অধিক পরিমানে জিংক সম্পৃক্ত করে ৪টি নতুন জাতের ধান উদ্ভাবন করা হয়েছে।</p><p>প্রতি কেজি জিংক চালে ২৪ মিলিগ্রাম পর্যন্ত জিংক পাওয়া যায়, জা আপনার শরীরের প্রায় ৭০% পর্যন্ত জিংকের চাহিদা পুরন করতে পারে। উল্লেখ্য যে, অধিক পরিমানে জিংক থাকা সত্ত্বেও এই ভাতের স্বাদ ও রংএর কোন পরিবর্তন হয় না।</p><p><strong>আমন মৌসুমে জিংক ধানের জাত</strong></p><figure class="table"><table><tbody><tr><td><p><strong>ব্রি ধান৬২</strong></p><p>&nbsp;</p><p>মাত্র ১০০ দিনে এই ধান পাকে, তাই আগাম রবিশস্য চাষ করা যায়।</p><p>হেক্টর প্রতি ফলন ৪-৪.৫ টন।</p><p>চালের আকার আকৃতি লম্বা, সরু ও রং সাদা অনেকটা ব্রি ধান২৮ এর মত।</p><p>প্রতি কেজি চালে গড়ে ১৯.৬ মিলিগ্রাম জিংক ও শতকরা ৯ ভাগ প্রোটিন আছে।</p><p>বছরের অন্যান্য মৌসুমেও ধান চাষ করা যায়।</p></td><td><p><strong>ব্রি ধান৭২</strong></p><p>&nbsp;</p><p>জীবনকাল ১২৫-১৩০ দিন</p><p>হেক্টর প্রতি ফলন ৫.৭-৭.৫ টন।</p><p>চালের আকার আকৃতি লম্বা, মোটা ও রং সাদা।</p><p>প্রতি কেজি চালে ২২.৮ মিলিগ্রাম জিংক আছে।</p><p>এ ধানের চাষাবাদে প্রচলিত জাতের চেয়ে কম পরিমানে ইউরিয়া সার লাগে।</p></td></tr></tbody></table></figure><p><strong>বোরো মৌসুমে জিংক ধানের জাত</strong></p><figure class="table"><table><tbody><tr><td><p><strong>ব্রি ধান৬৪</strong></p><p>জীবনকাল ১৪৫-১৫০ দিন</p><p>হেক্টর প্রতি ফলন ৬.৫-৭ টন।</p><p>চালের আকার আকৃতি মাঝারি, মোটা ও রং সাদা।</p><p>প্রতি কেজি চালে ২৪ মিলিগ্রাম জিংক আছে।</p><p>চাষাবাদ পদ্ধতি অন্যান্য উফশী বোরো ধানের মত।</p></td><td><p><strong>ব্রি ধান৭৪</strong></p><p>জীবনকাল ১৪৭ দিন।</p><p>হেক্টর প্রতি ফলন ৭.১-৮.৩ টন।</p><p>চালের আকার আকৃতি মাঝারি, মোটা ও রং সাদা।</p><p>প্রতি কেজি চালে ২৪.২ মিলিগ্রাম জিংক ও শতকরা ৮.৩ ভাগ প্রোটিন রয়েছে।</p><p>এই জাতটি মধ্যম মানের ব্লাস্ট রোগ প্রতিরোধী।</p></td></tr></tbody></table></figure><p>সুত্রঃ হারভেস্ট প্লাস, বাংলাদেশ</p>';
        $post->save();
        foreach ([18] as $categoryId) {
            $post->postCategory()->attach($categoryId);
        }
        try {
            $file1 = 'https://3c1703fe8d.site.internapcdn.net/newman/csz/news/800/2016/abiofortifie.jpg';
            $post->addMediaFromUrl($file1)->toMediaCollection('posts');
        } catch (DiskDoesNotExist | FileDoesNotExist | FileIsTooBig $e) {
            return response()->json(['error', $e], 500);
        }

        # Post 11 #:------------------------------------------------------------
        $post = new Post();
        $post->title = 'Tomato cultivation method in advance.';
        $post->slug = 'tomato-cultivation-method-in-advance';
        $post->type = 'farming-practice';
        $post->status = true;
        $post->user_id = 5;
        $post->author = 'Officer Nahid';
        $post->description = '<p><strong>আগাম টমেটো চাষ পদ্ধতি</strong></p><p>আগাম টমেটো চাষ করার জন্য প্রধান প্রধান জাত হচ্ছে­-</p><p>বিনাটমেটো ৩,</p><p>বিনাটমেটো ৪,</p><p>বারিটমেটো ৪,</p><p>বারিটমেটো ৫,</p><p>বারিটমেটো ৬ (চৈতী), ও</p><p>সামার কিং</p><p>পলিথিনের ছাউনিতে এসব জাত চাষ করা হয়। একটি ছাউনি ২০ মিটার&nbsp; X ২.৩ মিটার আকৃতির হলে ভালো। ৩০ সেন্টিমিটার চওড়া ২টি বীজতলায় লম্বালম্বিভাবে ১টি করে ছাউনির ব্যবস্থা করে নিতে হবে। ছাউনির খুঁটির উভয় পাশের উচ্চতা ১৫০ সেন্টিমিটার এবং মাঝখানের খুঁটির উচ্চতা ২১০ সেন্টিমিটার হতে হবে। জমি নৌকার ছইয়ের আকৃতি করে পলিথিন দিয়ে ছাউনি দিতে হয়। ২টি ছাউনির মাঝে ৭৫ সেন্টিমিটার চওড়া নিকাশ নালা রাখলে ভালো হয়। প্রতিটি ছাউনিতে ২টি বীজতলা রাখতে হবে।</p><p><strong>বীজতলা</strong></p><p>জমি থেকে বীজতলার উচ্চতা ২০ থেকে ২৫ সেন্টিমিটার রাখা দরকার। ২টি বীজতলার মাঝে ৩০ সেন্টিমিটার চওড়া নালা রাখতে হয়। প্রতিটি ছাউনিতে ৪টি সারি রাখতে হবে।</p><p><strong>চারা রোপণ</strong></p><p>২৫-৩০ দিন বয়সের চারা প্রতি বেডে ২ সারিতে রোপণ করতে হয়। সারি থেকে সারির দূরত্ব ৬০ সেন্টিমিটার এবং চারা থেকে চারার দূরত্ব ৪০ সেন্টিমিটার রাখলে ভালো হবে।</p><p><strong>টমেটো ক্ষেতে সেচ ও পানি নিষ্কাশন</strong></p><p>শুষ্ক মৌসুমে চাষ করলে টমেটোতে পানি সেচ দেয়া প্রয়োজন। ফসল ও মাটির অবস্থা বিবেচনা করে তিনবার সেচ দেয়া যেতে পারে। বৃষ্টির পানি নিকাশের ব্যবস্থা করতে হবে। টমেটোর চারা লাগানোর পর প্রথম সপ্তাহে প্রায় প্রতিদিন বিকাল বেলা সেচ দিতে হবে। এরপর প্রয়োজনে প্রতি সপ্তাহে বা ১৫ দিন পর পর একবার সেচ দিতে হবে। বর্ষা মৌসুমে তেমন একটা সেচের প্রয়োজন হয় না। টমেটো গাছ জলাবদ্ধতা সহ্য করতে পারে না।</p><p><strong>টমেটো ক্ষেতে আগাছা ও নিড়ানি</strong></p><p>টমেটোর জমি নিয়মিত পরিষ্কার করতে হবে। প্রথম ও দ্বিতীয় কিস্তির সার প্রয়োগের আগে পার্শ্বকুশি সহ মরাপাতা ছাটাই করে দিতে হবে। হরমোন প্রয়োগ সুবিধা এবং বাতাসে যেন হেলে না পড়ে সেজন্য বাঁশের কঞ্চি দ্বারা ঠেকনা দিতে হবে। প্রতিটি সেচের পরে মাটির উপরি ভাগের চটা বা চাকামাটি ভেঙে দিতে হবে যাতে মাটিতে পর্যাপ্ত বাতাস চলাচল করতে পারে।</p><p><strong>আগাম ফসল</strong></p><p>গ্রীষ্মকালীন টমেটোর জন্য টমাটোটোন নামক হরমোন প্রয়োগের প্রয়োজন হয়। হ্যান্ড স্প্রেয়ারের সাহায্যে ৫ চা চামচ (প্রতি লিটার পানিতে) টমাটোটোন শুধু ফুটন্ত ফুলে ৮ থেকে ১০ দিন অন্তর ২ বার স্প্রে করতে হয়। এ প্রযুক্তি উদ্ভাবনের ফলে সারা বছর টমেটো চাষ করা সম্ভব। টমাটোটোন দ্বারা উৎপাদিত ফলে বীজ হয় না।</p><p><strong>পোকা দমন</strong></p><p>শোষক পোকা এবং জাবপোকা গাছের রস শোষণ করে। শোষক পোকা দমনের জন্য ম্যালাথিয়ন, সেভিন কিংবা নেক্সিয়ন এবং জাবপোকা দমনের জন্য এফিডান ডাস্টিং (৫%) কিংবা সেফস, নেক্সিয়ন ও ডাইব্রম ব্যবহার করতে হয়।</p><p><strong>রোগ দমন</strong></p><p>টমেটোর ৩টি রোগ গুরুত্বপূর্ণ। ঢলে পড়া রোগ, টমেটো মোজাইক ভাইরাস এবং ফিউজেরিয়াম উইল্ট। ঢলে পড়া রোগে গাছে ফুল আসার আগেই ঢলে পড়ে। এ রোগে আক্রান্ত গাছ ধ্বংস করা, আক্রান্ত জমিতে পরবর্তী ৪-৫ বছর টমেটো, আলু, মরিচ ও বেগুন চাষ না করা এবং প্রতিরোধী জাত ব্যবহার করা। মোজাইক রোগে পাতা কুঁকড়ে যায়, গাছ ও ফলের বৃদ্ধি ব্যাহত হয়। এজন্য আক্রান্ত গাছ ধ্বংস করতে হয়। সুস্থ গাছে কীটনাশক ওষুধ ছিটানোর ব্যবস্থা দ্বারা ভাইরাস বহনকারী পোকার আগমন প্রতিরোধ করতে হয়। ফিউজেরিয়াম উইল্ট রোগে গাছ ঢলে পড়ে। পাতা হলুদাভ হয় এবং পাতা ভেতরের দিকে বেঁকে আসে। এ রোগ মাটির মাধ্যমে ছড়ায়। এ রোগে আক্রান্ত গাছ ধ্বংস করতে হয়।</p><p><strong>শস্য সংগ্রহ ও সংরক্ষণ</strong></p><p>রোপণের ২-৩ মাস পর থেকে ফল সংগ্রহ শুরু করা যায়। রঙিন নয় এরূপ টমেটো ১০ থেকে ১৫.৫০ সে. তাপে ৩০ দিন পর্যন্ত সংরক্ষণ করা যায়। পাকা টমেটো ৫০০ সে. তাপে ১০ দিন পর্যন্ত রাখা যায়।</p>';
        $post->save();
        foreach ([1, 7] as $categoryId) {
            $post->postCategory()->attach($categoryId);
        }
        try {
            $file1 = 'https://www.gardeningknowhow.com/wp-content/uploads/2019/07/tomatoes.jpg';
            $post->addMediaFromUrl($file1)->toMediaCollection('posts');
        } catch (DiskDoesNotExist | FileDoesNotExist | FileIsTooBig $e) {
            return response()->json(['error', $e], 500);
        }

        # Post 12 #:------------------------------------------------------------
        $post = new Post();
        $post->title = 'Benefits of using flora in rice.';
        $post->slug = 'benefits-of-using-flora-in-rice';
        $post->type = 'farming-practice';
        $post->status = true;
        $post->user_id = 1;
        $post->author = 'Nahid Ferdous';
        $post->description = "<p>Flora nitrobenzene is a 20% W / W enriched product that is used in all crops to increase yield by 20-25%. It is being widely used in about 20 countries of the world including Bangladesh.</p><p><strong>Amount and time of spraying:</strong></p><p>Paddy is usually sprayed 3 times. Mix 3 ml flora in every liter of water and spray well in the morning or afternoon.</p><p><strong>1st spray: </strong>20 days after planting the seedlings in the main land</p><p><strong>2nd spray:</strong> 20 days after 1st spray</p><p><strong>3rd spray:</strong> 20 days after 2nd spray</p><p>Benefits of spraying flora on paddy:</p><ol><li>&nbsp;Increases and lengthens the number of roots so that more nutrients can be absorbed from the soil.</li><li>The tree is firmly attached to the soil so that the tree does not tilt easily.</li><li>Increases the number of effective kushis to 22%.</li><li>Increases stem length up to 11%.</li><li>Increases the amount of grains per grain up to 24%.</li><li>Increases the weight of each grain by up to 15%.</li><li>Above all, it increases the yield of paddy by 20-25%.</li></ol><p><strong>The amount of farmer's profit from the use of rice flora:</strong></p><p>To use flora 3 times in paddy, a total of 300 ml of flora is required in 100 ml. Price of 300ml Flora (120 * 3 = Rs. 380). If Flora is sprayed 3 times according to the rules of paddy, at least 4 manas of paddy per bigha will be more If the price of paddy is 800 rupees per ounce, then the total price is 3200 rupees. If the cost of spraying is Rs.500 per bigha then the net profit is Rs.2800.</p>";
        $post->save();
        foreach ([1, 18] as $categoryId) {
            $post->postCategory()->attach($categoryId);
        }
        try {
            $file1 = 'https://cdn.shopify.com/s/files/1/1606/4187/products/IMG_2568_clipped_rev_1_800x.png?v=1576860279';
            $post->addMediaFromUrl($file1)->toMediaCollection('posts');
        } catch (DiskDoesNotExist | FileDoesNotExist | FileIsTooBig $e) {
            return response()->json(['error', $e], 500);
        }

        # Post 13 #:------------------------------------------------------------
        $post = new Post();
        $post->title = 'Harmful aspects of urea fertilizer work, deficiency or symptoms of overuse, overuse.';
        $post->slug = 'harmful-aspects-of-urea-fertilizer-work-deficiency-or-symptoms-of-overuse-overuse';
        $post->type = 'farming-practice';
        $post->status = true;
        $post->user_id = 5;
        $post->author = 'Officer Nahid';
        $post->description = "<p><strong>The work of urea fertilizer</strong></p><p>Urea is a nitrogen-rich chemical fertilizer that is widely used in crop lands. Urea fertilizer contains 46% nitrogen. Urea fertilizer provides nitrogen which helps in root growth. Adequate amount of plants and vegetables helps in production of leaves, stalks and stems. Urea fertilizer gives dark green color to the plants by producing chlorophyll. Helps to increase fruit size including kushi production. Helps in the production of sugars and proteins in plants. It also increases the rate of absorption of all other essential elements of the plant.</p><p><strong>Symptoms of nitrogen deficiency</strong></p><p>Chlorophyll synthesis is greatly reduced when there is a deficiency or lack of nitrogen nutrients in the soil. As a result, the tree loses its normal green color. In addition, the size of the leaves becomes smaller and the growth of the branches decreases and the tree becomes shorter. The petals begin to fade and the stalks and branches become narrower. Unusual stalks of pink or light red color. The apex of the middle vein of the old leaf is yellowish-brown in color and the leaf falls off prematurely. The size of flowers and fruits becomes slightly smaller and the yield decreases.</p><p><strong>Consequences of high doses of urea</strong></p><p>Excessive application of urea fertilizer weakens the plant. The production of flowers and fruits on the trees is somewhat delayed. Insect and disease attacks also increase. Many times the leaves become heavy and the tree bends. Excess nitrogen application causes many fruits to rot.</p>";
        $post->save();
        foreach ([1, 18] as $categoryId) {
            $post->postCategory()->attach($categoryId);
        }
        try {
            $file1 = 'https://www.bakhabarkissan.com/wp-content/uploads/2019/07/G07719-1024x836.jpg';
            $post->addMediaFromUrl($file1)->toMediaCollection('posts');
            $file2 = 'https://upload.wikimedia.org/wikipedia/commons/c/c5/Urea_Malaysia.png';
            $post->addMediaFromUrl($file2)->toMediaCollection('posts');
        } catch (DiskDoesNotExist | FileDoesNotExist | FileIsTooBig $e) {
            return response()->json(['error', $e], 500);
        }

        # Post 14 #:------------------------------------------------------------
        $post = new Post();
        $post->title = 'MOP or potash fertilizer work, deficiency or deficiency symptoms, harmful aspects of overuse.';
        $post->slug = 'mop-or-potash-fertilizer-work-deficiency-or-deficiency-symptoms-harmful-aspects-of-overuse';
        $post->type = 'farming-practice';
        $post->status = true;
        $post->user_id = 5;
        $post->author = 'Officer Nahid';
        $post->description = "<p>MOP or potash fertilizer work, deficiency or deficiency symptoms, harmful aspects of overuse</p><p>&nbsp;</p><p>MOP or muriate of potash contains 50% potassium. MOP fertilizer protects the permeability of plant cells. Helps in the transport of sugars in plants. Increases the effectiveness of iron and manganese. Helps in the production of protein or meat in plants. Participates in plant water absorption, assimilation and movement i.e. overall control. Strengthens the structure of the tree and enhances immunity. Maintains balance in nitrogen and phosphorus absorption.</p><p>&nbsp;</p><p>Symptoms of MOP fertilizer deficiency</p><p>When there is a deficiency of potash fertilizer in the tree, discoloration starts from the edges of the old leaves. Later brown tissue is seen in the inner veins of the leaves. Also the surface of the leaves tend to be wrinkled or folded. The tree takes on a distorted shape and the growth of the tree is reduced with small intersections. Later the main stem is tilted towards the ground. Insects and diseases attack the trees.</p><p>If the amount of MOP fertilizer is high</p><p>The higher the amount of potash applied to the soil or trees, the lower the absorption rate of calcium and boron. As a result, boron deficiency symptoms are seen. The rate of water emission decreases and the growth of the plant decreases abnormally.</p>";
        $post->save();
        foreach ([1, 18] as $categoryId) {
            $post->postCategory()->attach($categoryId);
        }
        try {
            $file1 = 'https://img3.exportersindia.com/product_images/bc-full/dir_177/5305009/mop-fertilizer-1516104082-3529362.jpeg';
            $post->addMediaFromUrl($file1)->toMediaCollection('posts');
        } catch (DiskDoesNotExist | FileDoesNotExist | FileIsTooBig $e) {
            return response()->json(['error', $e], 500);
        }

    }
}
