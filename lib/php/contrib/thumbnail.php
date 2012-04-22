<?php 

class Thumbnail  {

      // These are maximum values, either 
      // one may end up being less
    var $new_width;
    var $new_height;

    var $old_width;
    var $old_height;

      // Filename/extension  (foo.bar)
    var $infile;
    var $outfile;

      // Full or relative path to file
      // (/www/foo/bar), (foo/bar)
    var $indir = THUMB_INDIR;
    var $outdir = THUMB_OUTDIR;

      // Quality setting of output JPEG
    var $quality = THUMB_QUALITY;

      // String error gets placed here if we bork somewhere
    var $error = 1;


      // Constructor
    function thumbnail($width=THUMB_DEF_WIDTH, $height=0)  {
        if($width == 0)  {  $width = 0;  }
        if($height == 0)  {  $height = 0;  }

        $this->set_size($width, $height);
    }


      // Calculate the width and height of the new image (thumbnail)
      // based on the size of the old image if one of $new_width or
      // $new_height is specified, or absolutely if both are 
      // specified.
    function calculate_dimensions($old_width, $old_height)  {
        $this->old_width = $old_width;
        $this->old_height = $old_height;

        if($this->new_width != 0  &&  $this->new_height != 0)  {
            ;
        }
        elseif($this->new_width == 0)  {
            $this->new_width = $this->new_height / ($old_height/$old_width);
        }
        elseif($this->new_height == 0)  {
            $this->new_height = $this->new_width / ($old_width/$old_height);
        }
    }


    function set_size($width=0, $height=0)  {
        if($width == 0  &&  $height == 0)  {
            $this->error = "Width and height both set to 0.";
            return 0;
        }

        $this->new_width = $width;
        $this->new_height = $height;
        return 1;
    }


    function set_quality($quality)  {
        if($quality < 0  or  $quality > 100)  {
            $this->error = "Quality of output image cannot be less than 0 or greater than 100";
            return 0;
        }
        $this->quality = $quality;
        return 1;
    }


    function create($infile, $outfile="")  {
        $this->infile = $infile;

          // $size is an array containing the image size
          // 0 = Width, 1 = Height
        if (! ($size = GetImageSize("$this->indir/$infile")) )  {
            $this->error = "Could Not Open Image To Get Size.";
            return 0;
        }

        $this->calculate_dimensions($size[0], $size[1]);

          // 
        $arr = explode(".", $infile);
        if (sizeof($arr) < 2)  {
            $this->error = "Invalid filename for thumbnail outfile.";
            return 0;
        }

          // Set $this->outfile to the specified output filename
          // or default it to (filename-.ext)_tn.ext
        if ($outfile != "")  {
            $this->outfile = $outfile;
        }  else  {
            $this->outfile = sprintf("%s-%d-%d-%d-%d_tn.%s", 
                $arr[0], $this->old_width, $this->old_height, $this->new_width,
                $this->new_height, $arr[1]);
        }

        if (file_exists("$this->outdir/$this->outfile"))
            return $this->outfile;


        $thumbnail = imagecreate($this->new_width, $this->new_height);

          // error checking below!!!!! *crash*
        $old_image = imagecreatefromjpeg("$this->indir/$infile");

        imagecopyresized($thumbnail, $old_image, 0, 0, 0, 0, 
            $this->new_width, $this->new_height, 
            $this->old_width, $this->old_height);
  
        if(!imagejpeg($thumbnail, "$this->outdir/$this->outfile", $this->quality))  {
            $this->error = "Couldn't output thumbnail, imagejpeg() failure.";
            return 0;
        }

        return $this->outfile;
    }
}

/*
$thumb = new thumb(0, 100);

$file1 = $thumb->create("foo.jpg");

$thumb->set_size(100, 200);
$file2 = $thumb->create("foo.jpg");

echo "<IMG SRC='/~dragonk/php/temp/image_cache/$file1'>";
echo "<IMG SRC='/~dragonk/php/temp/image_cache/$file2'>";
*/

?>
