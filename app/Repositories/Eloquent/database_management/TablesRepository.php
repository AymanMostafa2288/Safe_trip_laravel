<?php
namespace App\Repositories\Eloquent\database_management;

use App\Repositories\Interfaces\database_management\TablesInterface;
use App\Models\Table;
use Illuminate\Support\Facades\DB;
use Artisan;
use Exception;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

class TablesRepository implements TablesInterface {

    private $field_strings=[];

    public function index($request,$id='*'){

        $table_name='cms_migration';
        $data=DB::table($table_name);
        if(array_key_exists('name',$request) && $request['name']!=''){
            $data=$data->where('name','like','%'.$request['name'].'%');
        }
        if(array_key_exists('created_at',$request) && $request['created_at']!=''){
            $data=$data->where('created_at',$request['created_at']);
        }
        if($id=='*'){
            $data=$data->get();

            $data=Table::transformCollection($data);
        }else{
            $data=$data->where('id',$id);
            $data=$data->first();
            $data=Table::transformArray($data);
        }


        return $data;
    }
    public function store($request){
        DB::beginTransaction();
        try{
            $table_name=env('DB_SUFFIX').$request->name;
            if (!Schema::hasTable($table_name)) {
                $store_db_table=$request->all();
                unset($store_db_table['_token']);
                $this->store_migration_table($store_db_table);
                if($request->with_table_translate=='no'){
                    $this->create_tables($request,$table_name,$request->storage_engine,false);
                }else{
                    $this->create_tables($request,$table_name,$request->storage_engine,true);
                }
            }
            DB::commit();
            return true;
        }catch(Exception $e){
            DB::rollBack();
            return false;
        }
    }
    public function create_migration_table(){
        $table_name='cms_migration';
        if (!Schema::hasTable($table_name)) {
            $ss= Schema::create($table_name, function($table){
                $table->increments('id');
                $table->text('name')->unique();
                $table->longText('value');
                $table->longText('note')->nullable();
                $table->timestamps();
            });
            Artisan::call('php artisan migrate:generate --tables="'.$table_name.'"');
        }
        return true;
    }
    public function store_migration_table($request){
        $table_name='cms_migration';
        $check_table_exist=DB::table($table_name)->where('name',$request['name'])->get();

        if($check_table_exist->count() == 0){
            DB::table($table_name)->insert([
                'name'=>$request['name'],
                'value'=>json_encode($request),
                'note'=>$request['note'],
            ]);
        }
        return true;
    }

    public function delete($id){
        $table_migration='cms_migration';
        $table_name=DB::table($table_migration)->where('id',$id)->first();
        if($table_name){
            $table_name=env('DB_SUFFIX').$table_name->name;
            $table_name_translate=$table_name.'_translate';

            DB::table($table_migration)->where('id',$id)->delete();
            Schema::dropIfExists($table_name_translate);
            Schema::dropIfExists($table_name);
        }
        return true;

    }

    public function trancate(){
        $table_migration='cms_migration';
        $table_name=DB::table($table_migration)->where('id',$id)->first();
        if($table_name){
            $table_name=env('DB_SUFFIX').$table_name->name;
            DB::table($table_name)->truncate();
        }
        return true;
    }

    private function create_tables($request,$table_name,$storage_engine,$translate_table=true,$soft_delete=true){
        $key=key($request->fields_record);
        $count=count($request->fields_record[$key]);
        Schema::create($table_name, function($table) use ($request,$count,$storage_engine,$soft_delete){
            $table->id();
            $this->create_fields($request,$table,$count);
            $table->integer('is_active')->default(1);
            $table->timestamps();
            $table->softDeletes();
            $table->engine = $storage_engine;
        });



        if($translate_table==true){

            $table_name_translate=$table_name.'_translate';
            $name=Str::lower($request->name).'_id';
            $type='foreign_id';
            $length=11;
            $default=null;
            $default_text=null;
            $indexed='indexed';
            // Start Create Foreign Key
            $this->field_strings['name'][]=$name;
            $this->field_strings['type'][]=$type;
            $this->field_strings['length'][]=$length;
            $this->field_strings['default'][]=$default;
            $this->field_strings['default_text'][]=$default_text;
            $this->field_strings['indexed'][]=$indexed;
            $this->field_strings['foreign_table'][] =$table_name;
            $this->field_strings['in_translate'][]='yes';
            // End Create Foreign Key

            // Start Create Language Slug
            $this->field_strings['name'][]='lang';
            $this->field_strings['type'][]='varchar';
            $this->field_strings['length'][]=4;
            $this->field_strings['default'][]='en';
            $this->field_strings['default_text'][]=$default_text;
            $this->field_strings['indexed'][]='indexed';
            $this->field_strings['foreign_table'][] =null;
            $this->field_strings['in_translate'][]='yes';
            // End Create Language Slug

            $fields=new \ArrayObject;
            $fields->fields_record=$this->field_strings;

            $this->create_tables($fields,$table_name_translate,$storage_engine,false,false);
        }

        return true;
    }

    private function create_fields($request,$table,$count){

        for($i=0;$i<$count;$i++){

            $name=$request->fields_record['name'][$i];
            $type=$request->fields_record['type'][$i];
            $length=$request->fields_record['length'][$i];
            $default=$request->fields_record['default'][$i];
            $default_text=$request->fields_record['default_text'][$i];
            $indexed=$request->fields_record['indexed'][$i];
            $comment=$request->fields_record['note'][$i];

            $in_translate=$request->fields_record['in_translate'][$i];
            if($in_translate=='yes'){

                $this->field_strings['name'][]=$name;
                $this->field_strings['type'][]=$type;
                $this->field_strings['length'][]=$length;
                $this->field_strings['default'][]=$default;
                $this->field_strings['default_text'][]=$default_text;
                $this->field_strings['indexed'][]=$indexed;
                $this->field_strings['foreign_table'][]=null;
                $this->field_strings['in_translate'][]='yes';

            }


            if(array_key_exists('foreign_table',$request->fields_record)){
                $foreign_table=$request->fields_record['foreign_table'][$i];
            }

            if($type=='int'){
                if($indexed=='unique'){
                    if($default=='as_defined'){
                        $table->integer($name)->unique()->define($default_text)->comment($comment);
                    }elseif($default=='null'){
                        $table->integer($name)->unique()->nullable()->comment($comment);
                    }else{
                        $table->integer($name)->unique()->comment($comment);
                    }
                }elseif($indexed=='indexed'){
                    if($default=='as_defined'){
                        $table->integer($name)->index()->define($default_text)->comment($comment);
                    }elseif($default=='null'){
                        $table->integer($name)->index()->nullable()->comment($comment);
                    }else{
                        $table->integer($name)->index()->comment($comment);
                    }
                }else{
                    if($default=='as_defined'){
                        $table->integer($name)->define($default_text)->comment($comment);
                    }elseif($default=='null'){
                        $table->integer($name)->nullable()->comment($comment);
                    }else{
                        $table->integer($name)->comment($comment);
                    }
                }
            }elseif($type=='foreign_id'){

                if($indexed=='unique'){
                    if($default=='as_defined'){
                        $table->unsignedBigInteger($name)->unique()->define($default_text)->comment($comment);
                    }elseif($default=='null'){
                        $table->unsignedBigInteger($name)->unique()->nullable()->comment($comment);
                    }else{
                        $table->unsignedBigInteger($name)->unique()->comment($comment);
                    }
                }elseif($indexed=='indexed'){
                    if($default=='as_defined'){
                        $table->unsignedBigInteger($name)->index()->define($default_text)->comment($comment);
                    }elseif($default=='null'){
                        $table->unsignedBigInteger($name)->index()->nullable()->comment($comment);
                    }else{
                        $table->unsignedBigInteger($name)->index()->comment($comment);
                    }
                }else{
                    if($default=='as_defined'){
                        $table->unsignedBigInteger($name)->define($default_text)->comment($comment);
                    }elseif($default=='null'){
                        $table->unsignedBigInteger($name)->nullable()->comment($comment);
                    }else{
                        $table->unsignedBigInteger($name)->comment($comment);
                    }
                }
                $table->foreign($name)->references('id')->on($foreign_table)->onDelete("cascade");
            }elseif($type=='varchar'){
                if($indexed=='unique'){
                    if($default=='as_defined'){
                        $table->string($name, $length)->unique()->define($default_text)->comment($comment);
                    }elseif($default=='null'){
                        $table->string($name, $length)->unique()->nullable()->comment($comment);
                    }else{
                        $table->string($name, $length)->unique()->comment($comment);
                    }
                }elseif($indexed=='indexed'){
                    if($default=='as_defined'){
                        $table->string($name, $length)->index()->define($default_text)->comment($comment);
                    }elseif($default=='null'){
                        $table->string($name, $length)->index()->nullable()->comment($comment);
                    }else{
                        $table->string($name, $length)->index()->comment($comment);
                    }
                }else{
                    if($default=='as_defined'){
                        $table->string($name, $length)->define($default_text)->comment($comment);
                    }elseif($default=='null'){
                        $table->string($name, $length)->nullable()->comment($comment);
                    }else{
                        $table->string($name, $length)->comment($comment);
                    }
                }
            }elseif($type=='text'){

                if($indexed=='unique'){
                    if($default=='as_defined'){
                        $table->text($name)->unique()->define($default_text)->comment($comment);
                    }elseif($default=='null'){
                        $table->text($name)->unique()->nullable()->comment($comment);
                    }else{
                        $table->text($name)->unique()->comment($comment);
                    }
                }elseif($indexed=='indexed'){
                    if($default=='as_defined'){
                        $table->text($name)->index()->define($default_text)->comment($comment);
                    }elseif($default=='null'){
                        $table->text($name)->index()->nullable()->comment($comment);
                    }else{
                        $table->text($name)->index()->comment($comment);
                    }
                }else{
                    if($default=='as_defined'){
                        $table->text($name)->define($default_text)->comment($comment);
                    }elseif($default=='null'){
                        $table->text($name)->nullable()->comment($comment);
                    }else{
                        $table->text($name)->comment($comment);
                    }
                }
            }elseif($type=='date'){
                if($indexed=='unique'){
                    if($default=='as_defined'){
                        $table->date($name)->unique()->define($default_text)->comment($comment);
                    }elseif($default=='null'){
                        $table->date($name)->unique()->nullable()->comment($comment);
                    }else{
                        $table->date($name)->unique()->comment($comment);
                    }
                }elseif($indexed=='indexed'){
                    if($default=='as_defined'){
                        $table->date($name)->index()->define($default_text)->comment($comment);
                    }elseif($default=='null'){
                        $table->date($name)->index()->nullable()->comment($comment);
                    }else{
                        $table->date($name)->index()->comment($comment);
                    }
                }else{
                    if($default=='as_defined'){
                        $table->date($name)->define($default_text)->comment($comment);
                    }elseif($default=='null'){
                        $table->date($name)->nullable()->comment($comment);
                    }else{
                        $table->date($name)->comment($comment);
                    }
                }
            }elseif($type=='big_int'){
                if($indexed=='unique'){

                    if($default=='as_defined'){
                        $table->bigInteger($name)->unique()->define($default_text)->comment($comment);
                    }elseif($default=='null'){
                        $table->bigInteger($name)->unique()->nullable()->comment($comment);
                    }else{
                        $table->bigInteger($name)->unique()->comment($comment);
                    }
                }elseif($indexed=='indexed'){
                    if($default=='as_defined'){
                        $table->bigInteger($name)->index()->define($default_text)->comment($comment);
                    }elseif($default=='null'){
                        $table->bigInteger($name)->index()->nullable()->comment($comment);
                    }else{
                        $table->bigInteger($name)->index()->comment($comment);
                    }
                }else{
                    if($default=='as_defined'){
                        $table->bigInteger($name)->define($default_text)->comment($comment);
                    }elseif($default=='null'){
                        $table->bigInteger($name)->nullable()->comment($comment);
                    }else{
                        $table->bigInteger($name)->comment($comment);
                    }
                }
            }elseif($type=='decimal'){
                if($indexed=='unique'){
                    if($default=='as_defined'){
                        $table->decimal($name, $length)->unique()->define($default_text)->comment($comment);
                    }elseif($default=='null'){
                        $table->decimal($name, $length)->unique()->nullable()->comment($comment);
                    }else{
                        $table->decimal($name, $length)->unique()->comment($comment);
                    }
                }elseif($indexed=='indexed'){
                    if($default=='as_defined'){
                        $table->decimal($name, $length)->index()->define($default_text)->comment($comment);
                    }elseif($default=='null'){
                        $table->decimal($name, $length)->index()->nullable()->comment($comment);
                    }else{
                        $table->decimal($name, $length)->index()->comment($comment);
                    }
                }else{
                    if($default=='as_defined'){
                        $table->decimal($name, $length)->define($default_text)->comment($comment);
                    }elseif($default=='null'){
                        $table->decimal($name, $length)->nullable()->comment($comment);
                    }else{
                        $table->decimal($name, $length)->comment($comment);
                    }
                }
            }elseif($type=='float'){
                if($indexed=='unique'){
                    if($default=='as_defined'){
                        $table->float($name, $length)->unique()->define($default_text)->comment($comment);
                    }elseif($default=='null'){
                        $table->float($name, $length)->unique()->nullable()->comment($comment);
                    }else{
                        $table->float($name, $length)->unique()->comment($comment);
                    }
                }elseif($indexed=='indexed'){
                    if($default=='as_defined'){
                        $table->float($name, $length)->index()->define($default_text)->comment($comment);
                    }elseif($default=='null'){
                        $table->float($name, $length)->index()->nullable()->comment($comment);
                    }else{
                        $table->float($name, $length)->index()->comment($comment);
                    }
                }else{
                    if($default=='as_defined'){
                        $table->float($name, $length)->define($default_text)->comment($comment);
                    }elseif($default=='null'){
                        $table->float($name, $length)->nullable()->comment($comment);
                    }else{
                        $table->float($name, $length)->comment($comment);
                    }
                }
            }elseif($type=='boolean'){
                if($indexed=='unique'){
                    if($default=='as_defined'){
                        $table->boolean($name)->unique()->define($default_text)->comment($comment);
                    }elseif($default=='null'){
                        $table->boolean($name)->unique()->nullable()->comment($comment);
                    }else{
                        $table->boolean($name)->unique()->comment($comment);
                    }
                }elseif($indexed=='indexed'){
                    if($default=='as_defined'){
                        $table->boolean($name)->index()->define($default_text)->comment($comment);
                    }elseif($default=='null'){
                        $table->boolean($name)->index()->nullable()->comment($comment);
                    }else{
                        $table->boolean($name)->index()->comment($comment);
                    }
                }else{
                    if($default=='as_defined'){
                        $table->boolean($name)->define($default_text)->comment($comment);
                    }elseif($default=='null'){
                        $table->boolean($name)->nullable()->comment($comment);
                    }else{
                        $table->boolean($name)->comment($comment);
                    }
                }
            }elseif($type=='date_time'){
                if($indexed=='unique'){
                    if($default=='as_defined'){
                        $table->dateTime($name)->unique()->define($default_text)->comment($comment);
                    }elseif($default=='null'){
                        $table->dateTime($name)->unique()->nullable()->comment($comment);
                    }else{
                        $table->dateTime($name)->unique()->comment($comment);
                    }
                }elseif($indexed=='indexed'){
                    if($default=='as_defined'){
                        $table->dateTime($name)->index()->define($default_text)->comment($comment);
                    }elseif($default=='null'){
                        $table->dateTime($name)->index()->nullable()->comment($comment);
                    }else{
                        $table->dateTime($name)->index()->comment($comment);
                    }
                }else{
                    if($default=='as_defined'){
                        $table->dateTime($name)->define($default_text)->comment($comment);
                    }elseif($default=='null'){
                        $table->dateTime($name)->nullable()->comment($comment);
                    }else{
                        $table->dateTime($name)->comment($comment);
                    }
                }
            }elseif($type=='timestamp'){
                if($indexed=='unique'){
                    if($default=='as_defined'){
                        $table->timestamp($name)->unique()->default($default_text)->comment($comment);
                    }elseif($default=='null'){
                        $table->timestamp($name)->unique()->nullable()->comment($comment);
                    }else{
                        $table->timestamp($name)->unique()->comment($comment);
                    }
                }elseif($indexed=='indexed'){
                    if($default=='as_defined'){
                        $table->timestamp($name)->index()->default($default_text)->comment($comment);
                    }elseif($default=='null'){
                        $table->timestamp($name)->index()->nullable()->comment($comment);
                    }else{
                        $table->timestamp($name)->index()->comment($comment);
                    }
                }else{
                    if($default=='as_defined'){
                        $table->timestamp($name)->default($default_text)->comment($comment);
                    }elseif($default=='null'){
                        $table->timestamp($name)->nullable()->comment($comment);
                    }else{
                        $table->timestamp($name)->comment($comment);
                    }
                }
            }elseif($type=='time'){
                if($indexed=='unique'){
                    if($default=='as_defined'){
                        $table->time($name)->unique()->define($default_text)->comment($comment);
                    }elseif($default=='null'){
                        $table->time($name)->unique()->nullable()->comment($comment);
                    }else{
                        $table->time($name)->unique()->comment($comment);
                    }
                }elseif($indexed=='indexed'){
                    if($default=='as_defined'){
                        $table->time($name)->index()->define($default_text)->comment($comment);
                    }elseif($default=='null'){
                        $table->time($name)->index()->nullable()->comment($comment);
                    }else{
                        $table->time($name)->index()->comment($comment);
                    }
                }else{
                    if($default=='as_defined'){
                        $table->time($name)->define($default_text)->comment($comment);
                    }elseif($default=='null'){
                        $table->time($name)->nullable()->comment($comment);
                    }else{
                        $table->time($name)->comment($comment);
                    }
                }
            }elseif($type=='date'){
                if($indexed=='unique'){
                    if($default=='as_defined'){
                        $table->date($name)->unique()->define($default_text)->comment($comment);
                    }elseif($default=='null'){
                        $table->date($name)->unique()->nullable()->comment($comment);
                    }else{
                        $table->date($name)->unique()->comment($comment);
                    }
                }elseif($indexed=='indexed'){
                    if($default=='as_defined'){
                        $table->date($name)->index()->define($default_text)->comment($comment);
                    }elseif($default=='null'){
                        $table->date($name)->index()->nullable()->comment($comment);
                    }else{
                        $table->date($name)->index()->comment($comment);
                    }
                }else{
                    if($default=='as_defined'){
                        $table->date($name)->define($default_text)->comment($comment);
                    }elseif($default=='null'){
                        $table->date($name)->nullable()->comment($comment);
                    }else{
                        $table->date($name)->comment($comment);
                    }
                }
            }elseif($type=='char'){
                if($indexed=='unique'){
                    if($default=='as_defined'){
                        $table->char($name, $length)->unique()->define($default_text)->comment($comment);
                    }elseif($default=='null'){
                        $table->char($name, $length)->unique()->nullable()->comment($comment);
                    }else{
                        $table->char($name, $length)->unique()->comment($comment);
                    }
                }elseif($indexed=='indexed'){
                    if($default=='as_defined'){
                        $table->char($name, $length)->index()->define($default_text)->comment($comment);
                    }elseif($default=='null'){
                        $table->char($name, $length)->index()->nullable()->comment($comment);
                    }else{
                        $table->char($name, $length)->index()->comment($comment);
                    }
                }else{
                    if($default=='as_defined'){
                        $table->char($name, $length)->define($default_text)->comment($comment);
                    }elseif($default=='null'){
                        $table->char($name, $length)->nullable()->comment($comment);
                    }else{
                        $table->char($name, $length)->comment($comment);
                    }
                }
            }elseif($type=='medium_text'){

                if($indexed=='unique'){
                    if($default=='as_defined'){
                        $table->mediumText($name)->unique()->define($default_text)->comment($comment);
                    }elseif($default=='null'){
                        $table->mediumText($name)->unique()->nullable()->comment($comment);
                    }else{
                        $table->mediumText($name)->unique()->comment($comment);
                    }
                }elseif($indexed=='indexed'){
                    if($default=='as_defined'){
                        $table->mediumText($name)->index()->define($default_text)->comment($comment);
                    }elseif($default=='null'){
                        $table->mediumText($name)->index()->nullable()->comment($comment);
                    }else{
                        $table->mediumText($name)->index()->comment($comment);
                    }
                }else{
                    if($default=='as_defined'){
                        $table->mediumText($name)->define($default_text)->comment($comment);
                    }elseif($default=='null'){
                        $table->mediumText($name)->nullable()->comment($comment);
                    }else{
                        $table->mediumText($name)->comment($comment);
                    }
                }
            }elseif($type=='long_text'){

                if($indexed=='unique'){
                    if($default=='as_defined'){
                        $table->longText($name)->unique()->define($default_text)->comment($comment);
                    }elseif($default=='null'){
                        $table->longText($name)->unique()->nullable()->comment($comment);
                    }else{
                        $table->longText($name)->unique()->comment($comment);
                    }
                }elseif($indexed=='indexed'){
                    if($default=='as_defined'){
                        $table->longText($name)->index()->define($default_text)->comment($comment);
                    }elseif($default=='null'){
                        $table->longText($name)->index()->nullable()->comment($comment);
                    }else{
                        $table->longText($name)->index()->comment($comment);
                    }
                }else{
                    if($default=='as_defined'){
                        $table->longText($name)->define($default_text)->comment($comment);
                    }elseif($default=='null'){
                        $table->longText($name)->nullable()->comment($comment);
                    }else{
                        $table->longText($name)->comment($comment);
                    }
                }

            }elseif($type=='enum'){

                if($indexed=='unique'){
                    if($default=='as_defined'){
                        $table->enum($name, $length)->unique()->define($default_text)->comment($comment);
                    }elseif($default=='null'){
                        $table->enum($name, $length)->unique()->nullable()->comment($comment);
                    }else{
                        $table->enum($name, $length)->unique()->comment($comment);
                    }
                }elseif($indexed=='indexed'){
                    if($default=='as_defined'){
                        $table->enum($name, $length)->index()->define($default_text)->comment($comment);
                    }elseif($default=='null'){
                        $table->enum($name, $length)->index()->nullable()->comment($comment);
                    }else{
                        $table->enum($name, $length)->index()->comment($comment);
                    }
                }else{
                    if($default=='as_defined'){
                        $table->enum($name, $length)->define($default_text)->comment($comment);
                    }elseif($default=='null'){
                        $table->enum($name, $length)->nullable()->comment($comment);
                    }else{
                        $table->enum($name, $length)->comment($comment);
                    }
                }

            }

        }

        return $table;
    }
    public function genrate_migration_files($table_name){

        $cmd = 'php '.base_path().'/artisan migrate:generate --tables="'.$table_name.'"';
        $exect=shell_exec($cmd);
        if(Schema::hasTable($table_name.'_translate')){
            $this->genrate_migration_files($table_name.'_translate');
        }
        return true;
    }
}

?>
