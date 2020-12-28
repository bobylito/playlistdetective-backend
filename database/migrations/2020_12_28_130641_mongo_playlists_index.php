<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;
use Jenssegers\Mongodb\Schema\Blueprint as SchemaBlueprint;

class MongoPlaylistsIndex extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $mongoConn = Schema::connection('mongodb');
        if ($mongoConn->hasTable('playlists')) {
            $mongoConn->table('playlists', function (
                SchemaBlueprint $collection
            ) {
                $collection->index('id', 'unique_id');
            });
        } else {
            $mongoConn->create('playlists', function (
                SchemaBlueprint $collection
            ) {
                $collection->index('id', 'unique_id');
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('mongodb')->table('playlists', function (
            SchemaBlueprint $collection
        ) {
            $collection->dropIndex('unique_id');
        });
    }
}
