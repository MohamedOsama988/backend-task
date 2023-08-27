<?php

namespace App\Console\Commands;

use App\Models\Book;
use Goutte\Client;
use Illuminate\Console\Command;
use Illuminate\Support\Str;
use Symfony\Component\HttpClient\HttpClient;

class WebScraping extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'web-scraping';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    public $max;
    /**
     * Execute the console command.
     */
    public function handle()
    {
        //
        $data = [];
        $client = new Client();
        $page = 1;
        do {
            $crawler = $client->request('GET', 'https://rashf.com/tag/39/' . $page);
            $num = $crawler->filter('body  div.container.my-5')->children();
            $pagination = $crawler->filter('.pagination')->children()->eq(4)->filter('a')->text();
            //dd($pagination);

            //dd(count($num));
            $i = 0;
            while ($i < count($num)) {
                //$crawler->filter('body  div.container.my-5')->each(function ($node) use ($client, &$data) {
                $sub = $num->eq($i)->children();
                $subI = 0;
                $innerAttr = [];
                while ($subI < count($sub)) {
                    //$num->eq($i)->filter('.col-md-3')->each(function ($secNode) use ($client, &$data, &$i) {

                    try {
                        $bookLink = $sub->eq($subI)->filter('a')->first()->link();
                        $bookDetail = $client->click($bookLink);
                        $title = $bookDetail->filter('main h1')->first()->text();
                        $getPagesCount = $bookDetail->filter('main .row .rtl ul')->children();
                        $pagesCount = $getPagesCount->eq(1)->text();
                        $author = $getPagesCount->eq(0)->text();
                        $publisher = $getPagesCount->eq(2)->filter('a')->text();
                        $img = $bookDetail->filter('main .row div img')->first()->attr('src');
                        $imgSrc = 'https://rashf.com' . substr($img, 1);
                        $pdf = $bookDetail->filter('main .row div .btn.btn-primary.rounded-pill.btn-xs')->first()->attr('href');
                        if ($pdf != null) {
                            if (Str::contains($pdf, '.pdf')) {
                            } else {
                                Str::replace('pdf', '.pdf', $pdf);
                            }
                            if (Str::contains($pdf, ' ')) {
                                Str::replace(' ', null, $pdf);
                            }
                        }
                        $innerAttr['title'] = $title;
                        $innerAttr['pagesCount'] = (Str::contains($pagesCount, 'صفحة') ? str_replace('صفحة', '', $pagesCount) : 'غير معرف عدد صفحات');
                        $innerAttr['author'] = (Str::contains($author, 'تأليف') ? str_replace('تأليف ', ' للمؤلف ', $author) : 'غير معرف مؤلف');
                        $innerAttr['publisher'] = (Str::contains($publisher, 'الناشر') ? str_replace(' الناشر ', '', $publisher) : 'غير معرف ناشر');
                        $innerAttr['img'] = $imgSrc;
                        $innerAttr['pdf'] = $pdf;
                        $data[] = $innerAttr;

                        $book = new Book();
                        $book->title = $title;
                        $book->pages_count = (Str::contains($pagesCount, 'صفحة') ? str_replace('صفحة', '', $pagesCount) : 'غير معرف عدد صفحات');
                        $book->author = (Str::contains($author, 'تأليف') ? str_replace('تأليف ', ' للمؤلف ', $author) : 'غير معرف مؤلف');
                        $book->publisher = (Str::contains($publisher, 'الناشر') ? str_replace(' الناشر ', '', $publisher) : 'غير معرف ناشر');
                        $book->img_src = $imgSrc;
                        $book->pdf_src = $pdf;
                        $book->save();
                        $subI++;
                        //dd($innerAttr);
                    } catch (\Throwable $th) {
                        //throw $th;
                        $subI++;
                    }
                }

                $i++;
                //});
            }
            // dd($innerAttr);
            //$data[] = $attrInner;
            //});
            //dd($data);
            $page++;
            if($this->max != null){
                if($page >= $this->max){
                    break;
                }
            }
            else{
                if($page >= 4){
                    break;
                }
            }
        } while ($page < 4);
        //dd($data);
        //$data = json_encode($data, JSON_UNESCAPED_UNICODE);
    }
}
