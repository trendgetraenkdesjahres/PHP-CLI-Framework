<?php

class CLIDisplay
{
    protected array $image_info;
    private  $image;
    protected array $output_info;

    public function __construct(string $image_file, int $width = 0)
    {   
        if(!$this->create_image($image_file))
        {
            throw new Exception( $image_file." is not a file" );  
        }

        //get window width if no specefic width is delivered
        if($width == 0)
        {
            $width = abs(get_bash('tput cols') * .7);
        }
        $this->output_info['width'] = $width;
        $this->output_info['height'] = $this->output_info['width'] * $this->image_info['radio'];
    }

    /**
     *
     * @param   string  $image_file  filename of image
     *
     * @return  resource|GdImage              image data
     */
    private function create_image($image_file)
    {
        if(!is_file($image_file))
        {
            return false;
        }

        //get image data
        $content = file_get_contents($image_file);
        $this->image = imagecreatefromstring($content);

        // get image meta
        $this->image_info['file'] = $image_file;
        $this->image_info['width'] = imagesx($this->image);
        $this->image_info['height'] = imagesy($this->image);
        $this->image_info['radio'] = $this->image_info['width'] / $this->image_info['height'];

        //return image data
        return $this->image;
    }

    /**
     * pixel
     *
     * @param   string  $color  color name
     * @param   string  $char   char to display color
     *
     * @return  string          colored pixel
     */

    private function pixel(string $color, string $char = '#')
    {
        global $cli;
        if(property_exists($cli['colorset'] ,$color))
        {
            return "\033[".$cli['colorset']->{$color}->ansi."m".$char;
        }

        return ' ';
    }

    public function display()
    {
        $output = "";
        $pixel_width = intval($this->image_info['width'] / $this->output_info['width']);
        $pixel_height = intval($pixel_width * 2.25);
        for($h = 0; $h < $this->image_info['height']; $h += $pixel_height)
        {
            for($w = 0; $w < $this->image_info['width']; $w += $pixel_width)
            {
                $color = imagecolorat($this->image, $w, $h);

                $a = ($color >> 24) & 0xFF;
                $r = ($color >> 16) & 0xFF;
                $g = ($color >> 8) & 0xFF;
                $b = $color  & 0xFF;
                $a = abs(($a / 127) - 1 );
                
                
                $output .= $this->pixel($this->get_closest_color($r, $g, $b));
                if($w + $pixel_width + 1> $this->image_info['width'])
                {
                    $output .= "\n";
                }
                
            }
        }

        echo $output;
    }

    private function get_closest_color(int $r, int $g, int $b)
    {
        global $cli;

        $closest_color = [
            'name' => 'black',
            'difference' => 255*255 + 255*255 + 255*255 + 1
        ];

        foreach($cli['colorset'] as $name => $avaiable_color)
        {
            $diff_r = ($r - $avaiable_color->r);
            $diff_g = ($g - $avaiable_color->g);
            $diff_b = ($b - $avaiable_color->b);
            $tmp = sqrt($diff_r*$diff_r + $diff_g*$diff_g + $diff_b+$diff_b);
            if($tmp < $closest_color['difference'])
            {
                $closest_color['difference'] = $tmp;
                $closest_color['name'] = $name;
            }
            
        }
        return $closest_color['name'];
    }
}

/**
 * display displays an image
 *
 * @param   string  $image  path to image
 *
 * @return  NULL         
 */
function display(string $image)
{
    $image = new CLIDisplay($image);
    $image->display();
}

class CLIColor
{
    public int $r;
    public int $g;
    public int $b;
    public string $ansi;

    public function __construct(int $r, int $g, int $b, string $ansi)
    {
        $this->r = $r;
        $this->g = $g;
        $this->b = $b;
        $this->ansi = $ansi;
    }
}

class CLIColorSet
{
        public CLIColor $black;
        public CLIColor $red;
        public CLIColor $green;
        public CLIColor $orange;
        public CLIColor $blue;
        public CLIColor $purple;
        public CLIColor $cyan;
        public CLIColor $light_grey;
        public CLIColor $dark_grey;
        public CLIColor $light_red;
        public CLIColor $light_green;
        public CLIColor $yellow;
        public CLIColor $light_blue;
        public CLIColor $light_purple;
        public CLIColor $light_cyan;
        public CLIColor $white;

        public function __construct()
        {
            $this->black = new CLIColor(0, 0, 0, '0;30');
            $this->red = new CLIColor(170, 0, 0, '0;31');
            $this->green = new CLIColor(0, 170, 0, '0;32');
            $this->orange = new CLIColor(170, 85, 0, '0;33');
            $this->blue = new CLIColor(0, 0, 170, '0;34');
            $this->purple = new CLIColor(170, 0, 170, '0;35');
            $this->cyan = new CLIColor(0, 170, 170, '0;36');
            $this->light_grey = new CLIColor(170, 170, 170, '0;37');

            $this->dark_grey = new CLIColor(85, 85, 85, '1;30');
            $this->light_red = new CLIColor(255, 85, 85, '1;31');
            $this->light_green = new CLIColor(85, 255, 85, '1;32');
            $this->yellow = new CLIColor(255, 255, 85, '1;33');
            $this->light_blue = new CLIColor(85, 85, 255, '1;34');
            $this->light_purple = new CLIColor(255, 85, 255, '1;35');
            $this->light_cyan = new CLIColor(85, 255, 255, '1;36');
            $this->white = new CLIColor(255, 255, 255, '1;37');
        }
}

init_cli_colorset();

function init_cli_colorset(){
    global $cli;
    $cli['colorset'] = new CLIColorSet;
}