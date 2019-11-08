<?php

namespace Twitter\Lib\Common;

class ImageUploader {
  private $_image_name;
  private $_origin_path;
  private $_thumb_path;
  private $_thumb_width;
  private $_image_type;
  private $_image_file_name;

  public function __construct($image_name, $origin_path, $thumb_path, $thumb_width) {
    $this->_image_name = $image_name;
    $this->_origin_path = $origin_path;
    $this->_thumb_path = $thumb_path;
    $this->_thumb_width = $thumb_width;
  }

  public function upload() {
    try {
      $this->validateUpload();
      $ext = $this->validateImageType();
      $save_path = $this->saveImage($ext);
      $this->createThumbnail($save_path);
    } catch(\Twitter\Exception\InvalidUploadImage $e) {
      echo $e->getMessage();
      exit;
    } catch(\Twitter\Exception\SizeOverUploadImage $e) {
      echo $e->getMessage();
      exit;
    }

    return $this->_image_file_name;
  }

  // アップロード異常がないか
  private function validateUpload() {
    if(!isset($_FILES[$this->_image_name]) || !isset($_FILES[$this->_image_name]["error"])) {
      throw new \Twitter\Exception\InvalidUploadImage();
    }
    
    switch($_FILES[$this->_image_name]["error"]) {
      case UPLOAD_ERR_OK:
        break;
      case UPLOAD_ERR_INI_SIZE:
      case UPLOAD_ERR_FORM_SIZE:
        throw new \Twitter\Exception\SizeOverUploadImage();
        break;
      default:
        throw new \Twitter\Exception\InvalidUploadImage();
        break;
    }
  }

  private function validateImageType() {
    $this->_image_type = exif_imagetype($_FILES[$this->_image_name]["tmp_name"]);

    switch($this->_image_type) {
      case IMAGETYPE_GIF:
        return "gif";
      case IMAGETYPE_JPEG:
        return "jpg";
      case IMAGETYPE_PNG:
        return "png";
      default:
        throw new \Twitter\Exception\InvalidUploadImage();
        break;
    }
  }

  private function saveImage($ext) {
    $this->_image_file_name = sprintf(
      "%s_%s.%s",
      time(),
      sha1(uniqid(mt_rand(), true)),
      $ext
    );

    $save_path = $this->_origin_path . "/" . $this->_image_file_name;
    $res = move_uploaded_file($_FILES[$this->_image_name]["tmp_name"], $save_path);

    if(!$res) {
      throw new \Twitter\Exception\InvalidUploadImage();
    }

    return $save_path;
  }

  public function createThumbnail($save_path) {
    $image_size = getimagesize($save_path);
    $width = $image_size[0];
    $height = $image_size[1];

    switch($this->_image_type) {
      case IMAGETYPE_GIF:
        $src_image = imagecreatefromgif($save_path);
        break;
      case IMAGETYPE_JPEG:
        $src_image = imagecreatefromjpeg($save_path);
        break;
      case IMAGETYPE_PNG:
        $src_image = imagecreatefrompng($save_path);
        break;
    }

    // 比率計算
    $thumb_height = round($height * $this->_thumb_width / $width);
    $thumb_image = imagecreatetruecolor($this->_thumb_width, $thumb_height);
    imagecopyresampled($thumb_image, $src_image, 0, 0, 0, 0, $this->_thumb_width, $thumb_height, $width, $height);

    switch($this->_image_type) {
      case IMAGETYPE_GIF:
        imagegif($thumb_image, $this->_thumb_path . "/" . $this->_image_file_name);
        break;
      case IMAGETYPE_JPEG:
        imagejpeg($thumb_image, $this->_thumb_path . "/" . $this->_image_file_name);
        break;
      case IMAGETYPE_PNG:
        imagepng($thumb_image, $this->_thumb_path . "/" . $this->_image_file_name);
        break;
    }
  }
}
