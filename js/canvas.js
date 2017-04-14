var $canvas = $('#canvas');
var canvas_w = $canvas.width();
var canvas_h = $canvas.height();

var hero_w = $canvas.width()/3;
var pixel_w = hero_w/11;
var pixel_h = pixel_w;

var total_rows = 23;
var total_columns = 23;
var cur_row = 0;
var cur_column = 0;

var background_color = "rgba(0,255,255,1)"

function init() {
	var stage = new createjs.Stage("canvas");
	var context = stage.canvas.getContext("2d"); 
	context.webkitImageSmoothingEnabled = context.mozImageSmoothingEnabled = false; 	

	var backgroundRect = drawPixel(background_color, canvas_w, canvas_h, 0, 0);
	stage.addChild(backgroundRect);

	// Draw sprite maps onto canvas 
	for (sprite in sprites) {
	
		cur_row = 0;
		cur_column = 0;
	
		for(row in sprites[sprite]['rows']) {
			total_rows = sprites[sprite]['rows'].length;
			total_columns = total_rows;

			//var pixel_w = canvas_w/total_rows;
			//var pixel_h = pixel_w;

			var row_string = sprites[sprite]['rows'][row];

			for (var i = 0, len = row_string.length; i < len; i++) {
				var color_key = parseInt(row_string[i]);
				//console.log(color_key);
				var pixel_color = sprites[sprite]['colors'][color_key];
				
				var x = (pixel_w * cur_column);
                var y = (pixel_h * cur_row);

				var pixel = drawPixel(pixel_color, pixel_w, pixel_h, x, y);
				if (pixel_color.slice(-1) == "0") {	
					pixel = drawPixel("rgba(0,255,255,1)", pixel_w, pixel_h, x, y);	
				}
				stage.addChild(pixel);

				cur_column +=1;
			}
			cur_row += 1;
			cur_column = 0;	
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
