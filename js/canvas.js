var $canvas = $('#canvas');
var canvas_w = $canvas.width();
var canvas_h = $canvas.height();

var total_rows = 23;
var total_columns = 23;
var cur_row = 0;
var cur_column = 0;
var cur_pixel = 1;

var pixel_w = canvas_w/total_rows;
var pixel_h = canvas_h/total_columns;

function init() {
	var stage = new createjs.Stage("canvas");
	var context = stage.canvas.getContext("2d"); 
	context.webkitImageSmoothingEnabled = context.mozImageSmoothingEnabled = false; 

	// Draw pixels onto canvas 
	for (sprite in sprites) {
		for (pixels in sprites[sprite]) {
			for (pixel in sprites[sprite][pixels]) {
				
				var pixel_color = sprites[sprite][pixels][pixel]['rgba']

				var x = (pixel_w * cur_column);
                var y = (pixel_h * cur_row);			

				if (pixel_color != "0") {
					var pixel = drawPixel(pixel_color, pixel_w, pixel_h, x, y);

					stage.addChild(pixel);
				} else {
					var pixel = drawPixel("rgba(0,255,255,1)", pixel_w, pixel_h, x, y);
					
					stage.addChild(pixel);
				}

				if (cur_pixel >= ((cur_row + 1) * total_rows)) {
                    cur_row += 1;
					cur_column = 0;
                } else {
					cur_column += 1;
				}
				cur_pixel += 1;
			}
		}
	}	

	stage.update();
}

function drawPixel(color, w, h, x, y) {
	var pixel = new createjs.Shape();
    pixel.graphics.beginFill(color).drawRect(0, 0, w, h);

	pixel.x = x;
	pixel.y = y;	

	return pixel;
}
