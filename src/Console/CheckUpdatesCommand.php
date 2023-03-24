<?php

namespace MichaelDrennen\Geonames\Console;

use Goutte\Client;
use Illuminate\Console\Command;
use MichaelDrennen\Geonames\Models\GeoSetting;
use Symfony\Component\DomCrawler\Crawler;

class CheckUpdatesCommand extends Command
{
    use GeonamesConsoleTrait;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'geonames:check-update
    {--connection= : If you want to specify the name of the database connection you want used.}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check and update geonames and alternative names as needed.';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(Client $client)
    {
        $today = date('Y-m-d');
        $localDirectoryPath = GeoSetting::getAbsoluteLocalStoragePath( $this->connectionName );
        $crawler = $client->request( 'GET', 'http://download.geonames.org/export/dump/');



        foreach($crawler->filter( 'a' )->each( function ( Crawler $node ) {
            return $node->attr( 'href' );
        }) as $link){
            $filename = basename($link);
            if(in_array($filename, ['modifications-' . $today . '.txt', 'deletes-' . $today . '.txt'])
                && !file_exists($localDirectoryPath . DIRECTORY_SEPARATOR . $filename)){
                $this->call( 'geonames:update-geonames', [ '--connection' => $this->connectionName ] );
            }
            if(in_array($filename, ['alternateNamesModifications-' . $today . '.txt', 'alternateNamesDeletes-' . $today . '.txt'])
                && !file_exists($localDirectoryPath . DIRECTORY_SEPARATOR . $filename)){
                    $this->call( 'geonames:update-alternate-names', [ '--connection' => $this->connectionName ] );
            }

        }
        return Command::SUCCESS;
    }
}
