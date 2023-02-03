<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Folder;
use App\User;
use App\Group;
use DB;
use App\Traits\LogAction;
use Illuminate\Support\Facades\Auth;
class FolderController extends Controller
{
  use LogAction;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $default = [
    'structure_table' => 'structure',   // the structure table (containing the id, left, right, level, parent_id and position fields)
    'data_table'    => 'structure',   // table for additional fields (apart from structure ones, can be the same as structure_table)
    'data2structure'  => 'id',      // which field from the data table maps to the structure table
    'structure'     => [    // which field (value) maps to what in the structure (key)
      'id'      => 'id',
      'left'      => 'lft',
      'right'     => 'rgt',
      'level'     => 'lvl',
      'parent_id'   => 'pid',
      'position'    => 'pos'
    ],
    'data'        => []      // array of additional fields from the data table
    ];
    protected $optionstruc= ['structure_table' => 'tree_struct', 'data_table' => 'tree_data', 'data' => ['nm']];

      public function __construct(){
        $this->options = array_merge($this->default, $this->optionstruc);
      }
    public function index()
    {

          try {
            $folders = Folder::all();
            return view('folders.list',['folders'=>$folders]);
          } catch (\Exception $e) {

          }

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      try {
        $users=User::all();
        $folders=Group::all();
        return view('folders.create',['users'=>$users,'groups'=>$folders]);
      } catch (\Exception $e) {

      }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
     public function ajax(Request $request){
       session(['node_id' => $request->id]);
       return session('node_id');
       // return $request->id;
     }
    public function store(Request $request)
    {
        // try {
        $no_of_users=count($request->input('user_id'));
          $no_of_groups=count($request->input('group_id'));
          $this->validate($request, ['name'=>'required|min:2']);
          $folder=new Folder();
          $folder->name=$request->name;
          $folder->default=0;
          $folder->position=0;

          if ($request->parent_id==''){
            $folder->parent_id=0;  }
            else{$request->parent_id;}
          $folder->save();
          if($no_of_users>0){
          for ($i=0; $i <$no_of_users ; $i++) {
            $folder->users()->attach($request->user_id[$i],['permission_id'=>1,'created_at' => date('Y-m-d H:i:s'),'updated_at'=>date('Y-m-d H:i:s')]);
          }
          }
          if($no_of_groups>0){
          for ($i=0; $i <$no_of_users ; $i++) {
            $folder->groups()->attach($request->group_id[$i],['permission_id'=>1,'created_at' => date('Y-m-d H:i:s'),'updated_at'=>date('Y-m-d H:i:s')]);
          }
          }

          return redirect()->route('folders')->with(['success'=>'Folder Created Successfully']);
        // } catch (\Exception $e) {
        //
        // }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request,$id)
    {

      try {
        $rslt = null;
        switch($id) {
          case 'analyze':
            return $this->analyze(true);

          break;
          case 'get_node':
          $node = isset($request->id) && $request->id !== '#' ? (int)$request->id : 0;
          $temp = $this->get_children($node);

          $rslt = array();
          foreach($temp as $v) {
            $rslt[] = array('id' => $v->id, 'text' => $v->nm, 'children' => ($v->rgt - $v->lft > 1));
          }
          break;

          case "get_content":
          $node = isset($request->id) && $request->id !== '#' ? $request->id : 0;
          $node = explode(':', $node);

          if(count($node) > 1) {
            $rslt = array('content' => 'Multiple selected');
          }
          else {

            $temp = $this->get_node((int)$node[0], array('with_path' => true));
            return $temp;
            $rslt = array('content' => 'Selected: /' . implode('/',array_map(function ($v) { return $v['nm']; }, $temp['path'])). '/'.$temp['nm']);
          }
          break;
          //from here
          case 'create_node':
          $node = isset($request->id) && $request->id !== '#' ? (int)$request->id : 0;
          $temp = $this->mk($node, isset($request->position) ? (int)$request->position : 0, array('nm' => isset($request->text) ? $request->text : 'New node'));
          $rslt = array('id' => $temp);
          break;
          case 'rename_node':
          $node = isset($request->id) && $request->id !== '#' ? (int)$request->id : 0;
          $rslt = $this->rn($node, ['nm' => isset($request->text) ? $request->text : 'Renamed node']);
          break;
          case 'delete_node':
          $node = isset($request->id) && $request->id !== '#' ? (int)$request->id : 0;
          $rslt = $this->rm($node);
          break;
          case 'move_node':
          $node = isset($request->id) && $request->id !== '#' ? (int)$request->id : 0;
          $parn = isset($request->parent) && $request->parent !== '#' ? (int)$request->parent : 0;
          $rslt = $this->mv($node, $parn, isset($request->position) ? (int)$request->position : 0);
          break;
          case 'copy_node':
          $node = isset($request->id) && $request->id !== '#' ? (int)$request->id : 0;
          $parn = isset($request->parent) && $request->parent !== '#' ? (int)$request->parent : 0;
          $rslt = $this->cp($node, $parn, isset($request->position) ? (int)$request->position : 0);
          break;
          default:
          throw new \Exception('Unsupported operation: ' . $id);
          break;
        }
        return response()->json($rslt);
      }
      catch (\Exception $e) {

        dd($e);
      }
        $folder=Folder::find($id);
        return $folder;
    }


  public function mk($parent, $position = 0, $data = array()) {
    $parent = (int)$parent;

    if($parent==0 && count($parent) == 0 ) { throw new \Exception('Parent is 0'); }
    $parent = $this->get_node($parent, array('with_children'=> true));

    $parent1=(array) $parent[0];

    $parent2= (array) !isset($parent['children'][0]) ? 0 : $parent['children'][0] ;

    if(!$parent['children']) { $position = 0; }
    if($parent['children'] && $position >= count($parent['children'])) { $position = count($parent['children']); }

    $sql = array();
    $par = array();

    // PREPARE NEW PARENT
    // update positions of all next elements
    $sql[] = "
      UPDATE ".$this->options['structure_table']."
        SET ".$this->options['structure']["position"]." = ".$this->options['structure']["position"]." + 1
      WHERE
        ".$this->options['structure']["parent_id"]." = ".(int)$parent1[$this->options['structure']['id']]." AND
        ".$this->options['structure']["position"]." >= ".$position."
      ";
    $par[] = false;

    // update left indexes
    $ref_lft = false;
    if(!$parent['children']) {
      $ref_lft = $parent1[$this->options['structure']["right"]];
    }
    else if(!isset($parent['children'][$position])) {
      $ref_lft = $parent1[$this->options['structure']["right"]];
    }
    else {
      $ref_lft = $parent2[$this->options['structure']["left"]];
    }
    $sql[] = "
      UPDATE ".$this->options['structure_table']."
        SET ".$this->options['structure']["left"]." = ".$this->options['structure']["left"]." + 2
      WHERE
        ".$this->options['structure']["left"]." >= ".(int)$ref_lft."
      ";
    $par[] = false;

    // update right indexes
    $ref_rgt = false;
    if(!$parent['children']) {
      $ref_rgt = $parent1[$this->options['structure']["right"]];
    }
    else if(!isset($parent['children'][$position])) {
      $ref_rgt = $parent1[$this->options['structure']["right"]];
    }
    else {
      $ref_rgt = $parent2[$this->options['structure']["left"]] + 1;
    }
    $sql[] = "
      UPDATE ".$this->options['structure_table']."
        SET ".$this->options['structure']["right"]." = ".$this->options['structure']["right"]." + 2
      WHERE
        ".$this->options['structure']["right"]." >= ".(int)$ref_rgt."
      ";
    $par[] = false;
    // INSERT NEW NODE IN STRUCTURE
    $sql[] = "INSERT INTO ".$this->options['structure_table']." (".implode(",", $this->options['structure']).") VALUES (?".str_repeat(',?', count($this->options['structure']) - 1).")";
    $tmp = array();
    foreach($this->options['structure'] as $k => $v) {
      switch($k) {
        case 'id':
          $tmp[] = null;
          break;
        case 'left':
          $tmp[] = (int)$ref_lft;
          break;
        case 'right':
          $tmp[] = (int)$ref_lft + 1;
          break;
        case 'level':
          $tmp[] = (int)$parent1[$v] + 1;
          break;
        case 'parent_id':
          $tmp[] = $parent1[$this->options['structure']['id']];
          break;
        case 'position':
          $tmp[] = $position;
          break;
        default:
          $tmp[] = null;
      }
    }
    $par[] = $tmp;

    foreach($sql as $k => $v) {
      try {
         if($k==3){

         $insert= DB::insert($v,$par[$k]);

         }
         else{
        // dd($v);
          DB::update($v);
         }
        //($v, $par[$k]);
      } catch(Exception $e) {
        $this->reconstruct();
        throw new \Exception('Could not create');
      }
    }
    if($data && count($data)) {
      $node = DB::getPdo()->lastInsertId();
      if(!$this->rn($node,$data)) {
        $this->rm($node);
        throw new \Exception('Could not rename after create');
      }
    }
    $logmsg='Folder created';
    $this->saveLog('info','App\Folder',$folder->id,'folders',$logmsg,Auth::user()->id);
    return $node;
  }

public function rn($id, $data) {
    if(!(int) DB::select('SELECT 1 AS res FROM '.$this->options['structure_table'].' WHERE '.$this->options['structure']['id'].' = '.(int)$id)) {
      throw new \Exception('Could not rename non-existing node');
    }
    $tmp = array();
    foreach($this->options['data'] as $v) {
      if(isset($data[$v])) {
        $tmp[$v] = $data[$v];
      }
    }
    if(count($tmp)) {
      $tmp[$this->options['data2structure']] = $id;
      $sql = "
        INSERT INTO
          ".$this->options['data_table']." (".implode(',', array_keys($tmp)).")
          VALUES(?".str_repeat(',?', count($tmp) - 1).")
        ON DUPLICATE KEY UPDATE
          ".implode(' = ?, ', array_keys($tmp))." = ?";
      $par = array_merge(array_values($tmp), array_values($tmp));
      try {
        DB::insert($sql, $par);

      }
      catch(Exception $e) {
        throw new \Exception('Could not rename');
      }
    }
    return true;
  }

    public function rm($id) {
    $id = (int)$id;
    if(!$id || $id === 1) { throw new \Exception('Could not create inside roots'); }
    $data = (array) $this->get_node($id, array('with_children' => true, 'deep_children' => true));
    $data1 =(array) $data[0];
    $lft = (int)$data1[$this->options['structure']["left"]];
    $rgt = (int)$data1[$this->options['structure']["right"]];
    $pid = (int)$data1[$this->options['structure']["parent_id"]];
    $pos = (int)$data1[$this->options['structure']["position"]];
    $dif = $rgt - $lft + 1;

    $sql = [];
    // deleting node and its children from structure
    $sql[] = "
      DELETE FROM ".$this->options['structure_table']."
      WHERE ".$this->options['structure']["left"]." >= ".(int)$lft." AND ".$this->options['structure']["right"]." <= ".(int)$rgt."
    ";
    // shift left indexes of nodes right of the node
    $sql[] = "
      UPDATE ".$this->options['structure_table']."
        SET ".$this->options['structure']["left"]." = ".$this->options['structure']["left"]." - ".(int)$dif."
      WHERE ".$this->options['structure']["left"]." > ".(int)$rgt."
    ";
    // shift right indexes of nodes right of the node and the node's parents
    $sql[] = "
      UPDATE ".$this->options['structure_table']."
        SET ".$this->options['structure']["right"]." = ".$this->options['structure']["right"]." - ".(int)$dif."
      WHERE ".$this->options['structure']["right"]." > ".(int)$lft."
    ";
    // Update position of siblings below the deleted node
    $sql[] = "
      UPDATE ".$this->options['structure_table']."
        SET ".$this->options['structure']["position"]." = ".$this->options['structure']["position"]." - 1
      WHERE ".$this->options['structure']["parent_id"]." = ".$pid." AND ".$this->options['structure']["position"]." > ".(int)$pos."
    ";
    // delete from data table
    if($this->options['data_table']) {
      $tmp = array();
      $tmp[] = (int)$data1['id'];
      if($data['children'] && is_array($data['children'])) {
        foreach($data['children'] as $v) {
          $tmp[] = (int)$v['id'];
        }
      }
      $sql[] = "DELETE FROM ".$this->options['data_table']." WHERE ".$this->options['data2structure']." IN (".implode(',',$tmp).")";
    }

    foreach($sql as $v) {
      try {
        DB::statement($v);
      } catch(Exception $e) {
        $this->reconstruct();
        throw new \Exception('Could not remove');
      }
    }
    return true;
  }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

  public function reconstruct($analyze = true) {
    if($analyze && $this->analyze()) { return true; }

    if(!DB::statement("" .
      "CREATE TEMPORARY TABLE temp_tree (" .
        "".$this->options['structure']["id"]." INTEGER NOT NULL, " .
        "".$this->options['structure']["parent_id"]." INTEGER NOT NULL, " .
        "". $this->options['structure']["position"]." INTEGER NOT NULL" .
      ") "
    )) { return false; }
    if(!DB::insert("" .
      "INSERT INTO temp_tree " .
        "SELECT " .
          "".$this->options['structure']["id"].", " .
          "".$this->options['structure']["parent_id"].", " .
          "".$this->options['structure']["position"]." " .
        "FROM ".$this->options['structure_table'].""
    )) { return false; }

    if(!DB::insert("" .
      "CREATE TEMPORARY TABLE temp_stack (" .
        "".$this->options['structure']["id"]." INTEGER NOT NULL, " .
        "".$this->options['structure']["left"]." INTEGER, " .
        "".$this->options['structure']["right"]." INTEGER, " .
        "".$this->options['structure']["level"]." INTEGER, " .
        "stack_top INTEGER NOT NULL, " .
        "".$this->options['structure']["parent_id"]." INTEGER, " .
        "".$this->options['structure']["position"]." INTEGER " .
      ") "
    )) { return false; }

    $counter = 2;
    if(!DB::select("SELECT COUNT(*) FROM temp_tree")) {
      return false;
    }
    //figure this out
    $this->db->nextr();
    $maxcounter = (int) $this->db->f(0) * 2;
    $currenttop = 1;
    if(!DB::insert("" .
      "INSERT INTO temp_stack " .
        "SELECT " .
          "".$this->options['structure']["id"].", " .
          "1, " .
          "NULL, " .
          "0, " .
          "1, " .
          "".$this->options['structure']["parent_id"].", " .
          "".$this->options['structure']["position"]." " .
        "FROM temp_tree " .
        "WHERE ".$this->options['structure']["parent_id"]." = 0"
    )) { return false; }
    if(!DB::delete("DELETE FROM temp_tree WHERE ".$this->options['structure']["parent_id"]." = 0")) {
      return false;
    }

    while ($counter <= $maxcounter) {
      if(!DB::select("" .
        "SELECT " .
          "temp_tree.".$this->options['structure']["id"]." AS tempmin, " .
          "temp_tree.".$this->options['structure']["parent_id"]." AS pid, " .
          "temp_tree.".$this->options['structure']["position"]." AS lid " .
        "FROM temp_stack, temp_tree " .
        "WHERE " .
          "temp_stack.".$this->options['structure']["id"]." = temp_tree.".$this->options['structure']["parent_id"]." AND " .
          "temp_stack.stack_top = ".$currenttop." " .
        "ORDER BY temp_tree.".$this->options['structure']["position"]." ASC LIMIT 1"
      )) { return false; }
        //figure this out
      if($this->db->nextr()) {
        $tmp = $this->db->f("tempmin");

        $q = "INSERT INTO temp_stack (stack_top, ".$this->options['structure']["id"].", ".$this->options['structure']["left"].", ".$this->options['structure']["right"].", ".$this->options['structure']["level"].", ".$this->options['structure']["parent_id"].", ".$this->options['structure']["position"].") VALUES(".($currenttop + 1).", ".$tmp.", ".$counter.", NULL, ".$currenttop.", ".$this->db->f("pid").", ".$this->db->f("lid").")";
        if(!DB::insert($q)) {
          return false;
        }
        if(!DB::delete("DELETE FROM temp_tree WHERE ".$this->options['structure']["id"]." = ".$tmp)) {
          return false;
        }
        $counter++;
        $currenttop++;
      }
      else {
        if(!DB::update("" .
          "UPDATE temp_stack SET " .
            "".$this->options['structure']["right"]." = ".$counter.", " .
            "stack_top = -stack_top " .
          "WHERE stack_top = ".$currenttop
        )) { return false; }
        $counter++;
        $currenttop--;
      }
    }

    $temp_fields = $this->options['structure'];
    unset($temp_fields["parent_id"]);
    unset($temp_fields["position"]);
    unset($temp_fields["left"]);
    unset($temp_fields["right"]);
    unset($temp_fields["level"]);
    if(count($temp_fields) > 1) {
      if(!DB::statement("" .
        "CREATE TEMPORARY TABLE temp_tree2 " .
          "SELECT ".implode(", ", $temp_fields)." FROM ".$this->options['structure_table']." "
      )) { return false; }
    }
    if(!DB::statement("TRUNCATE TABLE ".$this->options['structure_table']."")) {
      return false;
    }
    if(!DB::statement("" .
      "INSERT INTO ".$this->options['structure_table']." (" .
          "".$this->options['structure']["id"].", " .
          "".$this->options['structure']["parent_id"].", " .
          "".$this->options['structure']["position"].", " .
          "".$this->options['structure']["left"].", " .
          "".$this->options['structure']["right"].", " .
          "".$this->options['structure']["level"]." " .
        ") " .
        "SELECT " .
          "".$this->options['structure']["id"].", " .
          "".$this->options['structure']["parent_id"].", " .
          "".$this->options['structure']["position"].", " .
          "".$this->options['structure']["left"].", " .
          "".$this->options['structure']["right"].", " .
          "".$this->options['structure']["level"]." " .
        "FROM temp_stack " .
        "ORDER BY ".$this->options['structure']["id"].""
    )) {
      return false;
    }
    if(count($temp_fields) > 1) {
      $sql = "" .
        "UPDATE ".$this->options['structure_table']." v, temp_tree2 SET v.".$this->options['structure']["id"]." = v.".$this->options['structure']["id"]." ";
      foreach($temp_fields as $k => $v) {
        if($k == "id") continue;
        $sql .= ", v.".$v." = temp_tree2.".$v." ";
      }
      $sql .= " WHERE v.".$this->options['structure']["id"]." = temp_tree2.".$this->options['structure']["id"]." ";
      if(!DB::update($sql)) {
        return false;
      }
    }
    // fix positions
    $nodes = DB::select("SELECT ".$this->options['structure']['id'].", ".$this->options['structure']['parent_id']." FROM ".$this->options['structure_table']." ORDER BY ".$this->options['structure']['parent_id'].", ".$this->options['structure']['position']);
    $last_parent = false;
    $last_position = false;
    foreach($nodes as $node) {
      if((int)$node[$this->options['structure']['parent_id']] !== $last_parent) {
        $last_position = 0;
        $last_parent = (int)$node[$this->options['structure']['parent_id']];
      }
      DB::update("UPDATE ".$this->options['structure_table']." SET ".$this->options['structure']['position']." = ".$last_position." WHERE ".$this->options['structure']['id']." = ".(int)$node[$this->options['structure']['id']]);
      $last_position++;
    }
    if($this->options['data_table'] != $this->options['structure_table']) {
      // fix missing data records
      DB::insert("
        INSERT INTO
          ".$this->options['data_table']." (".implode(',',$this->options['data']).")
        SELECT ".$this->options['structure']['id']." ".str_repeat(", ".$this->options['structure']['id'], count($this->options['data']) - 1)."
        FROM ".$this->options['structure_table']." s
        WHERE (SELECT COUNT(".$this->options['data2structure'].") FROM ".$this->options['data_table']." WHERE ".$this->options['data2structure']." = s.".$this->options['structure']['id'].") = 0 "
      );
      // remove dangling data records
      DB::delete("
        DELETE FROM
          ".$this->options['data_table']."
        WHERE
          (SELECT COUNT(".$this->options['structure']['id'].") FROM ".$this->options['structure_table']." WHERE ".$this->options['structure']['id']." = ".$this->options['data_table'].".".$this->options['data2structure'].") = 0
      ");
    }
    return true;
  }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
    /**
     * method for all ajax calls.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
     // public function ajax(Request $request)
     // {
     //   # code...
     // }

public function resolve(){
 return ;
}

  public function get_node($id, $options = [] ) {
    $node=\DB::table($this->options['structure_table']." as s")
          ->leftJoin($this->options['data_table']." as d","s.".$this->options['structure']['id'],'=',"d.".$this->options['data2structure'])
          ->where("s.".$this->options['structure']['id'],$id)
          ->get()->toArray();

    if(!$node) {
      throw new \Exception('Node does not exist');
    }
    if(isset($options['with_children'])) {
      $node['children'] = $this->get_children($id, isset($options['deep_children']));
    }
    if(isset($options['with_path'])) {
      $node['path'] = $this->get_path($id);
    }
    return $node;
  }

  public function get_path($id) {
    $node =(array) $this->get_node($id)[0];

    $sql = false;

    if(count($node) > 0 ) {

      $sql = "
        SELECT
          s.".implode(", s.", $this->options['structure']).",
          d.".implode(", d.", $this->options['data'])."
        FROM
          ".$this->options['structure_table']." s,
          ".$this->options['data_table']." d
        WHERE
          s.".$this->options['structure']['id']." = d.".$this->options['data2structure']." AND
          s.".$this->options['structure']['left']." < ".(int)$node[$this->options['structure']['left']]." AND
          s.".$this->options['structure']['right']." > ".(int)$node[$this->options['structure']['right']]."
        ORDER BY
          s.".$this->options['structure']['left']."
      ";

    }

    return $sql ? DB::select($sql) : false;
  }

  public function get_children($id, $recursive = false) {
    $sql = false;
    if($recursive) {
      $node = (array) $this->get_node($id)[0];
      // dd($node['lft']);
      $sql = "
        SELECT
          s.".implode(", s.", $this->options['structure']).",
          d.".implode(", d.", $this->options['data'])."
        FROM
          ".$this->options['structure_table']." s,
          ".$this->options['data_table']." d
        WHERE
          s.".$this->options['structure']['id']." = d.".$this->options['data2structure']." AND
          s.".$this->options['structure']['left']." > ".(int)$node[$this->options['structure']['left']]." AND
          s.".$this->options['structure']['right']." < ".(int)$node[$this->options['structure']['right']]."
        ORDER BY
          s.".$this->options['structure']['left']."
      ";
    }
    else {
      $sql = "
        SELECT
          s.".implode(", s.", $this->options['structure']).",
          d.".implode(", d.", $this->options['data'])."
        FROM
          ".$this->options['structure_table']." s,
          ".$this->options['data_table']." d
        WHERE
          s.".$this->options['structure']['id']." = d.".$this->options['data2structure']." AND
          s.".$this->options['structure']['parent_id']." = ".(int)$id."
        ORDER BY
          s.".$this->options['structure']['position']."
      ";
    }
    return DB::select($sql);
  }

//Analyse the table for mismatch error
  public function analyze($get_errors = false) {

    $report = [];

    $gettbstruct=\DB::table($this->options['structure_table'])
                      ->where($this->options['structure']["parent_id"],0)
                      ->count($this->options['structure']["id"]);
    if($gettbstruct !==1){
       $report[] = "No or more than one root node.";
    }
    $gettbstruct1=\DB::table($this->options['structure_table'])
                      ->where($this->options['structure']["parent_id"],0)
                      ->select($this->options['structure']["left"]." as v")
                      ->first();

    if($gettbstruct1->v !==1){
       $report[] = "Root node's left index is not 1.";
    }

    $gettbstruct2=\DB::table($this->options['structure_table'])
                      ->where($this->options['structure']["parent_id"],'!=',0)
                      ->where($this->options['structure']["id"],$this->options['structure']["parent_id"])
                      ->count($this->options['structure']['id']);
    if($gettbstruct2>0){
       $report[] = "Missing parents.";
    }

  $rightIndex= \DB::table($this->options['structure_table'])
                    ->selectRaw("MAX(".$this->options['structure']["right"].") as max")
                    ->pluck('max');

  $rtcond2= (int) \DB::table($this->options['structure_table'])
                    ->count($this->options['structure']["id"]);

    if(($rightIndex[0]/2) != $rtcond2){
      $report[] = "Right index does not match node count.";
    }

    $dupliNext=\DB::table($this->options['structure_table'])
                    ->distinct($this->options['structure']["right"])
                    ->count($this->options['structure']["right"]);

    $dupliNext2=\DB::table($this->options['structure_table'])
                    ->distinct($this->options['structure']["left"])
                    ->count($this->options['structure']["left"]);
      if($dupliNext != $dupliNext2){

         $report[] = "Duplicates in nested set.";
      }


      $unique_help=\DB::table($this->options['structure_table'])
                          ->count($this->options['structure']["id"]);


      $leftN_unique2=\DB::table($this->options['structure_table'])
                          ->count($this->options['structure']["left"]) ;
      if($unique_help != $leftN_unique2){

        $report[] = "Left indexes not unique.";
      }

     $rightIndex_unique=\DB::table($this->options['structure_table'])
                          ->count($this->options['structure']["right"]);

      if($unique_help != $rightIndex_unique){

      $report[] = "Right indexes not unique.";

      }

     $Nested_set=\DB::table($this->options['structure_table']." as s1")
                      ->leftJoin($this->options['structure_table']." as s2",'s1.id','!=','s2.id')
                      ->where("s1.".$this->options['structure']['left'],'=',"s2.".$this->options['structure']['right'])
                      ->first();

    if($Nested_set) {
      $report[] = "Nested set - matching left and right indexes.";
    }

    if(
      (int) DB::select("
        SELECT
          ".$this->options['structure']["id"]." AS res
        FROM ".$this->options['structure_table']." s
        WHERE
          ".$this->options['structure']['position']." >= (
            SELECT
              COUNT(".$this->options['structure']["id"].")
            FROM ".$this->options['structure_table']."
            WHERE ".$this->options['structure']['parent_id']." = s.".$this->options['structure']['parent_id']."
          )
        LIMIT 1") ||
      (int) DB::select("
        SELECT
          s1.".$this->options['structure']["id"]." AS res
        FROM ".$this->options['structure_table']." s1, ".$this->options['structure_table']." s2
        WHERE
          s1.".$this->options['structure']['id']." != s2.".$this->options['structure']['id']." AND
          s1.".$this->options['structure']['parent_id']." = s2.".$this->options['structure']['parent_id']." AND
          s1.".$this->options['structure']['position']." = s2.".$this->options['structure']['position']."
        LIMIT 1")
    ) {
      $report[] = "Positions not correct.";
    }


    if((int) collect(DB::select("
      SELECT
        COUNT(".$this->options['structure']["id"].") as count FROM ".$this->options['structure_table']." s
      WHERE
        (
          SELECT
            COUNT(".$this->options['structure']["id"].")
          FROM ".$this->options['structure_table']."
          WHERE
            ".$this->options['structure']["right"]." < s.".$this->options['structure']["right"]." AND
            ".$this->options['structure']["left"]." > s.".$this->options['structure']["left"]." AND
            ".$this->options['structure']["level"]." = s.".$this->options['structure']["level"]." + 1
        ) !=
        (
          SELECT
            COUNT(*)
          FROM ".$this->options['structure_table']."
          WHERE
            ".$this->options['structure']["parent_id"]." = s.".$this->options['structure']["id"]."
        )"))->pluck('count')[0]
    ) {
      $report[] = "Missing records in data table.";
    }
      // return ;

    if($this->options['data_table'] &&
      (int) collect(DB::select("
        SELECT
          COUNT(".$this->options['data2structure'].") AS res
        FROM ".$this->options['data_table']." s
        WHERE
          (SELECT COUNT(".$this->options['structure']["id"].") FROM ".$this->options['structure_table']." WHERE ".$this->options['structure']["id"]." = s.".$this->options['data2structure'].") = 0
      "))->pluck('res')[0]
    ) {
      $report[] = "Dangling records in data table.";
    }

    // return $get_errors ? $report : count($report) == 0;
    return $get_errors ? $report : count($report);
  }

    public function mv($id, $parent, $position = 0) {
    $id     = (int)$id;
    $parent   = (int)$parent;
    if($parent == 0 || $id == 0 || $id == 1) {
      throw new \Exception('Cannot move inside 0, or move root node');
    }

    $parent   = $this->get_node($parent, array('with_children'=> true, 'with_path' => true));
    $id     = $this->get_node($id, array('with_children'=> true, 'deep_children' => true, 'with_path' => true));
    // dd($parent['path'][$this->options['structure']['id']]);
    if(!$parent['children']) {
      $position = 0;
    }
    if($id[$this->options['structure']['parent_id']] == $parent[$this->options['structure']['id']] && $position > $id[$this->options['structure']['position']]) {
      $position ++;
    }
    if($parent['children'] && $position >= count($parent['children'])) {
      $position = count($parent['children']);
    }
    if($id[$this->options['structure']['left']] < $parent[$this->options['structure']['left']] && $id[$this->options['structure']['right']] > $parent[$this->options['structure']['right']]) {
      throw new Exception('Could not move parent inside child');
    }

    $tmp = array();
    $tmp[] = (int)$id[$this->options['structure']["id"]];
    if($id['children'] && is_array($id['children'])) {
      foreach($id['children'] as $c) {
        $tmp[] = (int)$c[$this->options['structure']["id"]];
      }
    }
    $width = (int)$id[$this->options['structure']["right"]] - (int)$id[$this->options['structure']["left"]] + 1;

    $sql = array();

    // PREPARE NEW PARENT
    // update positions of all next elements
    $sql[] = "
      UPDATE ".$this->options['structure_table']."
        SET ".$this->options['structure']["position"]." = ".$this->options['structure']["position"]." + 1
      WHERE
        ".$this->options['structure']["id"]." != ".(int)$id[$this->options['structure']['id']]." AND
        ".$this->options['structure']["parent_id"]." = ".(int)$parent[$this->options['structure']['id']]." AND
        ".$this->options['structure']["position"]." >= ".$position."
      ";

    // update left indexes
    $ref_lft = false;
    if(!$parent['children']) {
      $ref_lft = $parent[$this->options['structure']["right"]];
    }
    else if(!isset($parent['children'][$position])) {
      $ref_lft = $parent[$this->options['structure']["right"]];
    }
    else {
      $ref_lft = $parent['children'][(int)$position][$this->options['structure']["left"]];
    }
    $sql[] = "
      UPDATE ".$this->options['structure_table']."
        SET ".$this->options['structure']["left"]." = ".$this->options['structure']["left"]." + ".$width."
      WHERE
        ".$this->options['structure']["left"]." >= ".(int)$ref_lft." AND
        ".$this->options['structure']["id"]." NOT IN(".implode(',',$tmp).")
      ";
    // update right indexes
    $ref_rgt = false;
    if(!$parent['children']) {
      $ref_rgt = $parent[$this->options['structure']["right"]];
    }
    else if(!isset($parent['children'][$position])) {
      $ref_rgt = $parent[$this->options['structure']["right"]];
    }
    else {
      $ref_rgt = $parent['children'][(int)$position][$this->options['structure']["left"]] + 1;
    }
    $sql[] = "
      UPDATE ".$this->options['structure_table']."
        SET ".$this->options['structure']["right"]." = ".$this->options['structure']["right"]." + ".$width."
      WHERE
        ".$this->options['structure']["right"]." >= ".(int)$ref_rgt." AND
        ".$this->options['structure']["id"]." NOT IN(".implode(',',$tmp).")
      ";

    // MOVE THE ELEMENT AND CHILDREN
    // left, right and level
    $diff = $ref_lft - (int)$id[$this->options['structure']["left"]];

    if($diff > 0) { $diff = $diff - $width; }
    $ldiff = ((int)$parent[$this->options['structure']['level']] + 1) - (int)$id[$this->options['structure']['level']];
    $sql[] = "
      UPDATE ".$this->options['structure_table']."
        SET ".$this->options['structure']["right"]." = ".$this->options['structure']["right"]." + ".$diff.",
          ".$this->options['structure']["left"]." = ".$this->options['structure']["left"]." + ".$diff.",
          ".$this->options['structure']["level"]." = ".$this->options['structure']["level"]." + ".$ldiff."
        WHERE ".$this->options['structure']["id"]." IN(".implode(',',$tmp).")
    ";
    // position and parent_id
    $sql[] = "
      UPDATE ".$this->options['structure_table']."
        SET ".$this->options['structure']["position"]." = ".$position.",
          ".$this->options['structure']["parent_id"]." = ".(int)$parent[$this->options['structure']["id"]]."
        WHERE ".$this->options['structure']["id"]."  = ".(int)$id[$this->options['structure']['id']]."
    ";

    // CLEAN OLD PARENT
    // position of all next elements
    $sql[] = "
      UPDATE ".$this->options['structure_table']."
        SET ".$this->options['structure']["position"]." = ".$this->options['structure']["position"]." - 1
      WHERE
        ".$this->options['structure']["parent_id"]." = ".(int)$id[$this->options['structure']["parent_id"]]." AND
        ".$this->options['structure']["position"]." > ".(int)$id[$this->options['structure']["position"]];
    // left indexes
    $sql[] = "
      UPDATE ".$this->options['structure_table']."
        SET ".$this->options['structure']["left"]." = ".$this->options['structure']["left"]." - ".$width."
      WHERE
        ".$this->options['structure']["left"]." > ".(int)$id[$this->options['structure']["right"]]." AND
        ".$this->options['structure']["id"]." NOT IN(".implode(',',$tmp).")
    ";
    // right indexes
    $sql[] = "
      UPDATE ".$this->options['structure_table']."
        SET ".$this->options['structure']["right"]." = ".$this->options['structure']["right"]." - ".$width."
      WHERE
        ".$this->options['structure']["right"]." > ".(int)$id[$this->options['structure']["right"]]." AND
        ".$this->options['structure']["id"]." NOT IN(".implode(',',$tmp).")
    ";

    foreach($sql as $k => $v) {
      //echo preg_replace('@[\s\t]+@',' ',$v) ."\n";
      try {
        DB::update($v);
      } catch(Exception $e) {
        $this->reconstruct();
        throw new \Exception('Error moving');
      }
    }
    return true;
  }
}
