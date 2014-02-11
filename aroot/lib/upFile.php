<?php
if(!defined("INC")) exit("Request Error!");

class FileUpload{
	private $filepath;//指定上传文件保存的路径
	private $allowtype=array('gif','jpg','png','jpeg');
	private $maxsize=1000000;//上传文件的最大长度 1M
	private $israndname=true;//是否随机重命名，true表示随机
	private $originName;	 //原文件名
	private $tmpFileName;	 //临时文件名
	private $fileType;	     //文件类型
	private $fileSize;
	private $newfileName;	 //新文件名
	private $errorNum=0;	 //错误号
	private $errorMess="";	 //错误消息

	/*	//初始化上传文件,这种初始化要求用户必须按顺序赋值，并且不可以将前几个属性值省略赋值，
		function __construct($filepath,$allowetype,$maxsize,$israndname){
		$this->filepath = $filepath;
		$this->allowetype = $allowtype;
		$this->maxsize = $maxsize;
		$this->israndname = $israndname;
		} */
	//让用户不用按位置传参数，后面参数给值不用将前几个参数也提供值，将参数作为数组，可以解决这类问题
	public function __construct($options=array()){
			
		foreach($options as $key=>$val){
			//解决用户赋值时大小写问题
			$key = strtolower($key);
			//判断用户参数中数组的下标是否和成员属性相同
			//get_class_vars()获得对象成员属性，get_class()获得对象名
			if(!in_array($key,get_class_vars(get_class($this)))){
				continue;
			}
			$this->setOption($key,$val);

		}
	}
	
	//用于获取上传后文件的文件名
	public function getNewFileName(){
		return $this->newFileName;
	}

	//上传如果失败，则调用这个方法，就可以输出错误消息
	public function getErrorMsg(){
		return $this->errorMess;
	}

	//将值赋给对应属性
	private function setOption($key,$val){
		$this->$key = $val;
	}

	//获取错误信息
	private function getError(){
		$str="上传文件<font color='red'>{$this->originName}</font>时出错：";
			
		switch($this->errorNum){
			case 4:
				$str.="没有文件被上传";
				break;
			case 3:
				$str.="文件只有部分上传";
				break;
			case 2:
				$str.="上传文件超过了HTML表单中MAX_FILE_SIZE选项指定的值";
				break;
			case 1:
				$str.="上传文件超过了php.ini中upload_max_filesize选项的值";
				break;
			case -1:
				$str.="未允许的类型";
				break;
			case -2:
				$str.="文件过大，不能超过{$this->maxsize}个字节";
				break;
			case -3:
				$str.="上传文件失败";
				break;
			case -4:
				$str.="建立存放上传文件的目录失败，请重新指定上传的目录";
				break;
			case -5:
				$str.="必须指定上传文件的路径";
				break;
			default:
				$str.="未知错误";
		}

		return $str.'<br>';

			
	}

	//用来检查文件上传路径
	private function checkFilePath(){
		if(empty($this->filepath)){
			$this->setOption('errorNum',-5);
			return false;
		}

		if(!file_exists($this->filepath) || !is_writeable($this->filepath)){
			if(!@mkdir($this->filepath,0755)){
				$this->setOption('errorNum',-4);
				return false;
			}
		}
		return true;
	}

	//检查文件尺寸
	private function checkFileSize(){
		if($this->fileSize > $this->maxsize){
			$this->setOption('errorNum','-2');
			return false;
		}else{
			return true;
		}
	}

	//检查文件类型
	private function checkFileType(){
		if(in_array(strtolower($this->fileType),$this->allowtype)){
			return true;
		}else{
			$this->setOption('errorNum','-1');
			return false;
		}
	}

	//设置上传后的文件名
	private function setNewFileName(){
		if($this->israndname){
			$this->setOption("newFileName",$this->proRandName());
		}else{
			$this->setOption("newFileName",$this->originName);
		}
	}

	//设置随机文件名称
	private function proRandName(){
		$fileName = date("YmdHis").rand(100,999);
		return $fileName.".".$this->fileType;
	}

	//用来上传一个文件
	function uploadfile($fileField){
		$return = true;
		//检查文件上传路径
		if(!$this->checkFilePath()){
			$this->errorMess=$this->getError();
			return false;
		}
		$name=$_FILES[$fileField]['name'];
		$tmp_name=$_FILES[$fileField]['tmp_name'];
		$size=$_FILES[$fileField]['size'];
		$error=$_FILES[$fileField]['error'];
		//echo $error;
		if($this->setFiles($name,$tmp_name,$size,$error)){
			if($this->checkFileSize() && $this->checkFileType()){
				$this->setNewFileName();
				if($this->copyFile()){
					return true;
				}else{
					$return = false;
				}
			}else{
				$return = false;
			}
		}else{
			$return = false;
		}
			
		if($return){
			$this->errorMess=$this->getError();
		}
		return $return;
	}

	//上传文件
	private function copyFile(){
		if(!$this->errorNum){
			$filepath=rtrim($this->filepath,'/').'/';
			$filepath.=$this->newFileName;

			if(@move_uploaded_file($this->tmpFileName,$filepath)){
				return true;

			}else{
				$this->setOption('errorNum','-3');
				return false;
			}
		}else{
			return false;
		}
	}

	//设置和$_FILES有关的内容
	private function setFiles($name="",$tmp_name="",$size=0,$error=0){
		$this->setOption('errorNum',$error);

		if($error){
			return false;
		}

		$this->setOption('originName',$name);
		$this->setOption('tmpFileName',$tmp_name);
		$arr=explode('.',$name);
		$this->setOption('fileType',strtolower($arr[count($arr)-1]));
		$this->setOption('fileSize',$size);

		return true;
	}

}
?>
