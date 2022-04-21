<?php 


function delete_file($file)
{	

	$file = explode('/',$file);
  
  $file_desc = isset($file[0]) ? $file[0] : null;
  $file_name = isset($file[1]) ? $file[1] : null;  

  if($file_desc AND $file_name)
  {
    \Storage::disk($file_desc)->delete($file_name);
  }
}

function uplode_file($file)
{
  $fileNamae = rand(1,100).time().'.'.$file->getClientOriginalExtension();
  $file->move(public_path('storage/files'), $fileNamae);
  return  'files/'. $fileNamae;
}

function files_path($file)
{
    return asset('public/storage/'. $file);
}



function uplode_user_image($file)
{
	$fileNamae = rand(1,100).time().'.'.$file->getClientOriginalExtension();
  $file->move(public_path('storage/users'), $fileNamae);
  return 'users/' . $fileNamae;
}


