<?php echo'<?php'; ?>

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TransitCreate{{ ucfirst($table) }}Table extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('{{ $table }}', function(Blueprint $table)
        {
            $table->increments('id');

            $table->string('path');
            $table->string('name');
            $table->string('extension');
            $table->string('mimetype');
            $table->bigInteger('size')->unsigned();
            $table->text('metadata')->default('{}');

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
        Schema::drop('{{ $table }}');
    }

}
