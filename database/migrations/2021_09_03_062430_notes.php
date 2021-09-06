<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Notes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        schema::create('notes', function (Blueprint $table) {
            $table->increments('id');  //unique 
            $table->string('title');
            $table->string('createdBy')->nullable();
            $table->string('assignedTo')->nullable();
           // $table->string('MailColab')->nullable();
            //$table->enum('collabarator',[0,1])->default(0);
            // $table->string('collabMail')->nullable()->change();
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onUpdate('cascade');
            $table->rememberToken();
            $table->timestamps();
         });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
