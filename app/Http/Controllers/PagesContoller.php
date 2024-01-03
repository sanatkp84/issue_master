<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Category;
use App\Models\Activity;
use App\Models\Report;
use App\Models\EditedReport;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PagesContoller extends Controller
{
    

    public function dashboard(){
        $id = auth::user()->id;
        $user = User::find($id);
        
        
        $usersWithReports = User::withCount('reports')
    ->whereHas('reports', function ($query) {
        $query->where('incident_deleted', 0);
    })
    ->get();
    
    

// Bar Chart
    
    $reportCounts = Report::getMonthlyCounts(); 
$report_chart = json_encode($reportCounts, true);

// PieChart

     
        // Fetch data for reports by nature
        $reportNatureData = Report::selectRaw('incident_nature, COUNT(*) as count')
            ->groupBy('incident_nature')
            ->get()
            ->pluck('count', 'incident_nature')
            ->toArray();

        // Set a threshold for nature types to be grouped under "Others"
        $threshold = 5; // You can adjust this based on your preference

        // Identify nature types to be grouped under "Others"
        $othersData = [];
        $significantData = [];

        foreach ($reportNatureData as $nature => $count) {
            if ($count <= $threshold) {
                $othersData[$nature] = $count;
            } else {
                $significantData[$nature] = $count;
            }
        }

        // Remove "Others" if there are no nature types to be grouped under it
        if (count($othersData) === 0) {
            unset($significantData['Others']);
        }

        // Group lesser occurring nature types under "Others"
        if (!empty($othersData)) {
            $significantData['Others'] = array_sum($othersData);
        }
    
        return view("Admin.dashboard" ,compact('user' ,'report_chart','reportCounts','usersWithReports','reportNatureData'));
        
        }
        
        
        
        
          public function category(){
              
               $data = Category::all();
               return view("Admin.category" ,compact('data'));
              
          }
          
          
              public function category_post(Request $request){
              
              if($request->id){
                  
                $data= Category::find($request->id);
            $data->category_name= $request->name;
            $data->update(); 
                   $this->ActivityFunction(auth::user()->id, "User Update the Category "); 
              }else{
                 
               $data= new Category();
            $data->category_creator_id= auth::user()->id;
            $data->category_name= $request->name;
            $data->save(); 
                    $this->ActivityFunction(auth::user()->id, "User Created new Category ");
              }
    
        

            
               return redirect('/category');
              
          }
          
          
          
          
           public function edit_category($id){
              
               $single_category = Category::find($id);
                $data = Category::all();
               return view("Admin.category" ,compact('data' ,'single_category'));
              
          }
          
          
          
            public function delete_category($id){
                
                
                 $single_category = Category::destroy($id);
                 $this->ActivityFunction(auth::user()->id, "User Delete the Category ");
               return redirect('/category');
            }
          
          
          
        
         public function SingleReportView($id){
     
        $report = Report::find($id);
$prevoius_data = EditedReport::where('report_id', $id)->orderBy('id', 'desc')->get();

        return view("Admin.report_info" ,compact('report', 'prevoius_data'));
        
        }
        
        
       
 public function ActivityFunction($id , $activityText)
    {
        // dd($activity);
         $activity  = new Activity();
        
          $activity->user_id= $id;
          $activity->activity= $activityText;
         $activity->save();
        
        }


}
