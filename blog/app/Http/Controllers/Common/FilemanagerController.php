<?php namespace App\Http\Controllers\Common;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Image;
use App\Models\Pagination;
use App\Http\Controllers\ConfigController;

use Illuminate\Http\Request;
use Auth;

class FilemanagerController extends Controller {

	protected $data = null;

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		$this->middleware('auth');
		$this->data = new \stdClass();
		$this->config = new ConfigController();

		// create define
		$this->data->dir_image = $this->config->dir_image;
		$this->data->http_best_path = $this->config->http_best_path;
		$this->data->https_best_path = $this->config->https_best_path;
		$this->data->auth_id = ((Auth::check())? Auth::user()->id:'0');
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function getIndex()
	{
		$request = \Request::all();
		// add system log
        $this->systemLogs('view', 'filemanager', $request);
        // End

		$data = [];
		$data['diractories'] = [];

		if (isset($request['filter_name'])) {
			$filter_name = rtrim(str_replace(array('../', '..\\', '..', '*'), '', $request['filter_name']), '/');
		} else {
			$filter_name = null;
		}

		// Make sure we have the correct directory
		if (isset($request['directory'])) {
			$directory = rtrim($this->data->dir_image . 'catalog/'.$this->data->auth_id.'/' . str_replace(array('../', '..\\', '..'), '', $request['directory']), '/');
			
			// define array diractories
			$data['diractories'] = explode('/', $request['directory']);
		} else {
			$directory = $this->data->dir_image . 'catalog/'.$this->data->auth_id;
		}

		// create user diractory
		if(!is_dir($directory)) {
			mkdir($directory, 0777, true);
			chmod($directory, 0777);
		}

		if (isset($request['page'])) {
			$page = $request['page'];
		} else {
			$page = 1;
		}

		$data['images'] = array();

		// Get directories
		$directories = glob($directory . '/' . $filter_name . '*', GLOB_ONLYDIR);

		if (!$directories) {
			$directories = array();
		}

		// Get files
		$files = glob($directory . '/' . $filter_name . '*.{jpg,jpeg,png,gif,JPG,JPEG,PNG,GIF}', GLOB_BRACE);

		if (!$files) {
			$files = array();
		}

		// Merge directories and files
		$images = array_merge($directories, $files);

		// Get total number of files and directories
		$image_total = count($images);

		// Split the array based on current page number and max number of items per page of 10
		$images = array_splice($images, ($page - 1) * 30, 30);

		foreach ($images as $image) {
			$name = str_split(basename($image), 14);

			if (is_dir($image)) {
				$url = '';

				if (isset($request['target'])) {
					$url .= '&target=' . $request['target'];
				}

				if (isset($request['thumb'])) {
					$url .= '&thumb=' . $request['thumb'];
				}

				$data['images'][] = array(
					'thumb' => '',
					'name'  => implode(' ', $name),
					'type'  => 'directory',
					'path'  => substr($image, strlen($this->data->dir_image)),
					'href'  => url('filemanager?directory=' . urlencode(substr($image, strlen($this->data->dir_image . 'catalog/'.$this->data->auth_id.'/'))).$url)
				);
			} elseif (is_file($image)) {
				// Find which protocol to use to pass the full image link back
				// if ($this->request->server['HTTPS']) {
				// 	$server = $this->data->https_best_path;
				// } else {
				// 	$server = $this->data->http_best_path;
				// }
				$server = $this->data->http_best_path;

				$data['images'][] = array(
					'thumb' => $this->resize(substr($image, strlen($this->data->dir_image)), 120, 80),
					'name'  => implode(' ', $name),
					'type'  => 'image',
					'path'  => substr($image, strlen($this->data->dir_image)),
					'href'  => $server . '/images/' . substr($image, strlen($this->data->dir_image))
				);
			}
		}

		$data['heading_title'] = trans('filemanager.title');
		$data['text_diractory_image'] = trans('filemanager.diractory_image');

		$data['text_no_results'] = trans('filemanager.no_file');
		$data['text_confirm'] = trans('filemanager.confirm_delete');

		$data['entry_search'] = trans('filemanager.search').' ...';
		$data['entry_folder'] = trans('filemanager.folder_name');

		$data['button_parent'] = trans('filemanager.parent');
		$data['button_back'] = trans('filemanager.back');
		$data['button_add'] = trans('button.add');
		$data['button_close'] = trans('button.close');
		$data['button_refresh'] = trans('filemanager.refresh');
		$data['button_upload'] = trans('filemanager.upload');
		$data['button_folder'] = trans('filemanager.new_folder');
		$data['button_delete'] = trans('filemanager.delete');
		$data['button_search'] = trans('filemanager.search');

		if (isset($request['directory'])) {
			$data['directory'] = urlencode($request['directory']);
		} else {
			$data['directory'] = '';
		}

		if (isset($request['filter_name'])) {
			$data['filter_name'] = $this->config->escape($request['filter_name']);
		} else {
			$data['filter_name'] = '';
		}

		// Return the target ID for the file manager to set the value
		if (isset($request['target'])) {
			$data['target'] = $request['target'];
		} else {
			$data['target'] = '';
		}

		// Return the thumbnail for the file manager to show a thumbnail
		if (isset($request['thumb'])) {
			$data['thumb'] = $request['thumb'];
		} else {
			$data['thumb'] = '';
		}

		// Parent
		$url = '';

		if (isset($request['directory'])) {
			$pos = strrpos($request['directory'], '/');

			if ($pos) {
				$url .= '&directory=' . urlencode(substr($request['directory'], 0, $pos));
			}
		}

		if (isset($request['target'])) {
			$url .= '&target=' . $request['target'];
		}

		if (isset($request['thumb'])) {
			$url .= '&thumb=' . $request['thumb'];
		}

		$data['parent'] = url('/filemanager?loading=yes'.$url);

		// Refresh
		$url = '';

		if (isset($request['directory'])) {
			$url .= '&directory=' . urlencode($request['directory']);
		}

		if (isset($request['target'])) {
			$url .= '&target=' . $request['target'];
		}

		if (isset($request['thumb'])) {
			$url .= '&thumb=' . $request['thumb'];
		}

		$data['refresh'] = url('/filemanager?loading=yes'.$url);

		$url = '';

		if (isset($request['directory'])) {
			$url .= '&directory=' . urlencode(html_entity_decode($request['directory'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($request['filter_name'])) {
			$url .= '&filter_name=' . urlencode(html_entity_decode($request['filter_name'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($request['target'])) {
			$url .= '&target=' . $request['target'];
		}

		if (isset($request['thumb'])) {
			$url .= '&thumb=' . $request['thumb'];
		}

		$pagination = new Pagination();
		$pagination->total = $image_total;
		$pagination->page = $page;
		$pagination->limit = 30;
		$pagination->url = url('filemanager?loading=yes' . $url . '&page={page}');

		$data['pagination'] = $pagination->render();

		// load profile
		$data['action_form_crop_profile'] = url('account/load-cropit-form');

		return view('common.filemanager.index', compact('data'));
	}

	public function postUpload() {
		$request = \Request::all();
		// add system log
        $this->systemLogs('upload', 'filemanager', $request);
        // End
		$json = array();

		// Make sure we have the correct directory
		if (isset($request['directory'])) {
			$directory = rtrim($this->data->dir_image . 'catalog/'.$this->data->auth_id.'/' . str_replace(array('../', '..\\', '..'), '', $request['directory']), '/');
		} else {
			$directory = $this->data->dir_image . 'catalog/'.$this->data->auth_id;
		}

		// Check its a directory
		if (!is_dir($directory)) {
			$json['error'] = trans('filemanager.check').': ' .$directory.' '.trans('filemanager.directory_not_exist');
		}

		// Return any upload error
		$array_error_upload_fille = [
			'1' => trans('filemanager.UPLOAD_ERR_INI_SIZE'),
			'2' => trans('filemanager.UPLOAD_ERR_FORM_SIZE'),
			'3' => trans('filemanager.UPLOAD_ERR_PARTIAL'),
			'4' => trans('filemanager.UPLOAD_ERR_NO_FILE'),
			'6'	=> trans('filemanager.UPLOAD_ERR_NO_TMP_DIR'),
			'7' => trans('filemanager.UPLOAD_ERR_CANT_WRITE'),
			'8' => trans('filemanager.UPLOAD_ERR_EXTENSION')
		];

		if ($_FILES['file']['error'] != UPLOAD_ERR_OK) {
			// $json['error'] = 'Error: error_upload_' . $_FILES['file']['error'];
			$json['error'] = trans('filemanager.check').': ' . (( isset($array_error_upload_fille[$_FILES['file']['error']]) )? $array_error_upload_fille[$_FILES['file']['error']]:$_FILES['file']['error']);
		}

		if (!$json) {
			if (!empty($_FILES['file']['name']) && is_file($_FILES['file']['tmp_name'])) {
				// Sanitize the filename
				$filename = basename(html_entity_decode($_FILES['file']['name'], ENT_QUOTES, 'UTF-8'));

				// Validate the filename length
				if ((strlen($filename) < 3) || (strlen($filename) > 255)) {
					$json['error'] = trans('filemanager.check').': ' .trans('filemanager.filename_value_between');
				}

				// Allowed file extension types
				$allowed = array(
					'jpg',
					'jpeg',
					'gif',
					'png'
				);

				if (!in_array(strtolower(substr(strrchr($filename, '.'), 1)), $allowed)) {
					$json['error'] = trans('filemanager.check').': ' .trans('filemanager.incorrect_file_type');
				}

				// Allowed file mime types
				$allowed = array(
					'image/jpeg',
					'image/pjpeg',
					'image/png',
					'image/x-png',
					'image/gif'
				);

				if (!in_array($_FILES['file']['type'], $allowed)) {
					$json['error'] = trans('filemanager.check').': ' .trans('filemanager.incorrect_file_type');
				}

				// Check to see if any PHP files are trying to be uploaded
				$content = file_get_contents($_FILES['file']['tmp_name']);

				if (preg_match('/\<\?php/i', $content)) {
					$json['error'] = trans('filemanager.check').': ' .trans('filemanager.incorrect_file_type');
				}

				// Return any upload error
				if ($_FILES['file']['error'] != UPLOAD_ERR_OK) {
					$json['error'] = 'Error: error_upload_' . $_FILES['file']['error'];
				}
			} else {
				$json['error'] = trans('filemanager.check').': ' .trans('filemanager.error_unknown_reason');
			}
		}

		if (!$json) {
			// upload image
			move_uploaded_file($_FILES['file']['tmp_name'], $directory . '/' . $filename);

			// compress image
			$n = 3;
			$compress_size = ceil((((filesize($directory . '/' . $filename)/1024)/1024)/$n));

			if($compress_size < 1) {
				$compress_size = 1;
			}

			if($compress_size > 4) {
				$compress_size = 4;
			}

			$array_value = [
				'1' => 25,
				'2' => 20,
				'3' => 15,
				'4' => 10
			];

			$this->compress_image($directory . '/' . $filename, $directory . '/' . $filename, $array_value[$compress_size]);

			$json['success'] = trans('filemanager.success_upload');
		}

		return json_encode($json);
	}

	public function postFolder() {
		$request = \Request::all();
		// add system log
        $this->systemLogs('create_folder', 'filemanager', $request);
        // End
		$json = [];

		// Make sure we have the correct directory
		if (isset($request['directory'])) {
			$directory = rtrim($this->data->dir_image . 'catalog/'.$this->data->auth_id.'/' . str_replace(array('../', '..\\', '..'), '', $request['directory']), '/');
		} else {
			$directory = $this->data->dir_image . 'catalog/'.$this->data->auth_id;
		}

		// Check its a directory
		if (!is_dir($directory)) {
			$json['error'] = trans('filemanager.check').': ' .trans('filemanager.directory_not_exist');
		}

		if (!$json) {
			// Sanitize the folder name
			$folder = $this->config->escape(str_replace(array('../', '..\\', '..'), '', basename(html_entity_decode($request['folder'], ENT_QUOTES, 'UTF-8'))));

			// Validate the filename length
			if ((strlen($folder) < 3) || (strlen($folder) > 128)) {
				$json['error'] = trans('filemanager.check').': ' .trans('filemanager.foldername_value_between');
			}

			// Check if directory already exists or not
			if (is_dir($directory . '/' . $folder)) {
				$json['error'] = trans('filemanager.check').': ' .trans('filemanager.directory_same_name');
			}
		}

		if (!$json) {
			mkdir($directory . '/' . $folder, 0777);
			chmod($directory . '/' . $folder, 0777);

			$json['success'] = trans('filemanager.success_directory_created');
		}

		return json_encode($json);
	}

	public function postDelete() {
		$request = \Request::all();
		// add system log
        $this->systemLogs('delete', 'filemanager', $request);
        // End
		$json = [];

		if (isset($request['path'])) {
			$paths = $request['path'];
		} else {
			$paths = [];
		}

		// Loop through each path to run validations
		foreach ($paths as $path) {
			$path = rtrim($this->data->dir_image . str_replace(array('../', '..\\', '..'), '', $path), '/');

			// Check path exsists
			if ($path == $this->data->dir_image . 'catalog') {
				$json['error'] = trans('filemanager.check').': ' .trans('filemanager.directory_can_not_delete');

				break;
			}
		}

		if (!$json) {
			// Loop through each path
			foreach ($paths as $path) {
				$path = rtrim($this->data->dir_image . str_replace(array('../', '..\\', '..'), '', $this->config->escape($path)), '/');

				// If path is just a file delete it
				if (is_file($path)) {
					unlink($path);

				// If path is a directory beging deleting each file and sub folder
				} elseif (is_dir($path)) {
					$files = array();

					// Make path into an array
					$path = array($path . '*');

					// While the path array is still populated keep looping through
					while (count($path) != 0) {
						$next = array_shift($path);

						foreach (glob($next) as $file) {
							// If directory add to path array
							if (is_dir($file)) {
								$path[] = $file . '/*';
							}

							// Add the file to the files to be deleted array
							$files[] = $file;
						}
					}

					// Reverse sort the file array
					rsort($files);

					foreach ($files as $file) {
						// If file just delete
						if (is_file($file)) {
							unlink($file);

						// If directory use the remove directory function
						} elseif (is_dir($file)) {
							rmdir($file);
						}
					}
				}
			}

			$json['success'] = trans('filemanager.success_delete_directory');
		}

		return json_encode($json);
	}

	public function resize($filename, $width, $height) {
		if (!is_file($this->data->dir_image . $filename)) {
			return;
		}

		$extension = pathinfo($filename, PATHINFO_EXTENSION);

		$old_image = $filename;
		$new_image = 'cache/' . substr($filename, 0, strrpos($filename, '.')) . '-' . $width . 'x' . $height . '.' . $extension;

		if (!is_file($this->data->dir_image . $new_image) || (filectime($this->data->dir_image . $old_image) > filectime($this->data->dir_image . $new_image))) {
			$path = '';

			$directories = explode('/', dirname(str_replace('../', '', $new_image)));

			foreach ($directories as $directory) {
				$path = $path . '/' . $directory;

				if (!is_dir($this->data->dir_image . $path)) {
					@mkdir($this->data->dir_image . $path, 0777);
				}
			}

			list($width_orig, $height_orig) = getimagesize($this->data->dir_image . $old_image);

			if ($width_orig != $width || $height_orig != $height) {
				$image = new Image($this->data->dir_image . $old_image);
				$image->resize($width, $height);
				$image->save($this->data->dir_image . $new_image);
			} else {
				copy($this->data->dir_image . $old_image, $this->data->dir_image . $new_image);
			}
		}

		// if ($this->request->server['HTTPS']) {
		// 	return https_best_path . 'image/' . $new_image;
		// } else {
		// 	return http_best_path . 'image/' . $new_image;
		// }

		return $this->data->http_best_path. '/images/' . $new_image;
	}

	public function resizeWithWatermark($filename, $width, $height, $watermark, $position) {

		// check if watermark has removed from original library
		if($watermark=='' || !is_file($this->data->dir_image . $watermark)) {
			$watermark = 'watermark_koktep.png';
		}

		if($position=='') {
			$position = 'center';
		}

		if (!is_file($this->data->dir_image . $filename)) {
			return;
		}

		$extension = pathinfo($filename, PATHINFO_EXTENSION);

		$old_image = $filename;
		$new_image = 'cache/' . substr($filename, 0, strrpos($filename, '.')) . '-' . $width . 'x' . $height . '.' . $extension;

		if (!is_file($this->data->dir_image . $new_image) || (filectime($this->data->dir_image . $old_image) > filectime($this->data->dir_image . $new_image))) {
			$path = '';

			$directories = explode('/', dirname(str_replace('../', '', $new_image)));

			foreach ($directories as $directory) {
				$path = $path . '/' . $directory;

				if (!is_dir($this->data->dir_image . $path)) {
					@mkdir($this->data->dir_image . $path, 0777);
				}
			}

			list($width_orig, $height_orig) = getimagesize($this->data->dir_image . $old_image);

			if ($width_orig != $width || $height_orig != $height) {
				$image = new Image($this->data->dir_image . $old_image);
				$image->resize($width, $height);

				// add this two lines
        		$imageW = new Image($this->data->dir_image . $watermark); // link to your watermark image
        		$image->watermark($imageW, $position);  // topleft, topright, bottomleft or bottomright

				$image->save($this->data->dir_image . $new_image);
			} else {
				copy($this->data->dir_image . $old_image, $this->data->dir_image . $new_image);
			}
		}

		// if ($this->request->server['HTTPS']) {
		// 	return https_best_path . 'image/' . $new_image;
		// } else {
		// 	return http_best_path . 'image/' . $new_image;
		// }

		return $this->data->http_best_path. '/images/' . $new_image;
	}

	function compress_image($source_url, $destination_url, $quality) {
		$info = getimagesize($source_url);
	 
		if ($info['mime'] == 'image/jpeg') $image = imagecreatefromjpeg($source_url);
		elseif ($info['mime'] == 'image/pjpeg') $image = imagecreatefromjpeg($source_url);
		elseif ($info['mime'] == 'image/gif') $image = imagecreatefromgif($source_url);
		elseif ($info['mime'] == 'image/png') $image = imagecreatefrompng($source_url);
		elseif ($info['mime'] == 'image/x-png') $image = imagecreatefrompng($source_url);
	 
		//save file
		imagejpeg($image, $destination_url, $quality);
	 
		//return destination file
		return $destination_url;
	}

}
