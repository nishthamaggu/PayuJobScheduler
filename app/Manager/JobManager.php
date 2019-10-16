<?php

namespace App\Manager;
use \Illuminate\Support\Facades\DB;
use File;
use App\Files;
use App\Jobs\MakeCsvExcel;

class JobManager	{
	
	public function processJobs()
	{
		try{
			$weekly_jobs = DB::table('job')->where('routine', '=', "weekly")->get();
			$daily_jobs = DB::table('job')->where('routine', '=', "daily")->get();
			$monthly_jobs = DB::table('job')->where('routine', '=', "monthly")->get();
			$hourly_jobs = DB::table('job')->where('routine', '=', "hourly")->get();

			if(count($daily_jobs)){
				//dispatch at execution time
				foreach ($daily_jobs as $daily_job) {
					$now = date("h:i:s");
					$start_time = $daily_job->start_time;
					$to = \Carbon\Carbon::createFromFormat('H:i:s', $now);
					$from = \Carbon\Carbon::createFromFormat('H:i:s', $start_time);
					$diff_in_minutes = $to->diffInMinutes($from);
					if($to > $from)
						$diff_in_minutes = 24*60 - $diff_in_minutes;

					MakeCsvExcel::dispatch($daily_job)->delay(now()->addMinutes($diff_in_minutes));
				}
			}

			if(count($weekly_jobs)){
				//dispatch on the basis of day at execution time
				foreach ($weekly_jobs as $weekly_job) {
					$current_day = strtolower(date('l'));
					if($weekly_job->day == $current_day){
						$now = date("h:i:s");
						$start_time = $hourly_job->start_time;
						$to = \Carbon\Carbon::createFromFormat('H:i:s', $now);
						$from = \Carbon\Carbon::createFromFormat('H:i:s', $start_time);
						$diff_in_minutes = $to->diffInMinutes($from);
						if($to > $from)
							$diff_in_minutes = 24*60 - $diff_in_minutes;

						MakeCsvExcel::dispatch($weekly_job)->delay(now()->addMinutes($diff_in_minutes));
					}
				}
			}

			if(count($monthly_jobs)){
				//dispatch on the basis of date of month at execution time
				foreach ($monthly_jobs as $monthly_job) {
					$current_day = date("d");
					$job_day = date('d', strtotime($hourly_job->created_at));
					if($current_day == $job_day){
						$now = date("h:i:s");
						$start_time = $hourly_job->start_time;
						$to = \Carbon\Carbon::createFromFormat('H:i:s', $now);
						$from = \Carbon\Carbon::createFromFormat('H:i:s', $start_time);
						$diff_in_minutes = $to->diffInMinutes($from);
						if($to > $from)
							$diff_in_minutes = 24*60 - $diff_in_minutes;

						MakeCsvExcel::dispatch($monthly_job)->delay(now()->addMinutes($diff_in_minutes));
					}
				}
			}

			if(count($hourly_jobs)){
				//add 1 hr 24 times and then dispatch
				foreach ($hourly_jobs as $hourly_job) {
					$now = date("H:i:s");
					$start_time = $hourly_job->start_time;
					$to = \Carbon\Carbon::createFromFormat('H:i:s', $now);
					$from = \Carbon\Carbon::createFromFormat('H:i:s', $start_time);
					$diff_in_minutes = $to->diffInMinutes($from);
					if($to > $from)
						$diff_in_minutes = 24*60 - $diff_in_minutes;
					$min = 0;
					for($i=1; $i<=24; $i++){
						MakeCsvExcel::dispatch($hourly_job)->delay(now()->addMinutes($diff_in_minutes + $min));
						$min += 60;
					}
					

				}
			}


		}
		catch(\Exception $e){
			dd($e);
			return null;
		}
	}

	public function makeFile($job)
	{
		try{
			$data = DB::select(DB::raw($job->query));
			$file_path = $this->writeToCSV($data, $job->job_id, time());
			$file = new Files();
			$file->job_id = $job->job_id;
			$file->file_path = $file_path;
			$file->save();
		}
		catch(\Exception $e){
			dd($e);
			return null;
		}
	}
	protected function writeToCSV($data, $job_id, $time)
    {
    	$path = 'test_'.$job_id.'_'.$time.'.csv';
        $this->createCSV('jobs/', "test_".$job_id."_$time".'.csv', $data);
        return $path;
    }

	public static function createCSV($path, $fileName, $array)
    {
	    	if (!file_exists('/storage/'.$path)) {
			    File::makeDirectory('/storage/'.$path, 0777, true, true);
			}
	        $file = fopen(storage_path($path.$fileName), 'a');
	        $flag = true;
	        foreach ($array as $key => $row) {
	        	if($flag){
	        		$head = array_keys((array)$row);
	        		fputcsv($file, $head);
	        		$flag = !$flag;
	        	}
	            fputcsv($file, (array)$row);
	        }
	        fclose($file);
    }
}
