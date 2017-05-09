var $canvas = $('#canvas');
var canvas_w = $canvas.width();
var canvas_h = $canvas.height();
var stage;

var units_x = 40;
var units_y = 40; 

var hero_w = $canvas.width()/3;
var pixel_w = Math.floor(canvas_w/units_x);
var pixel_h = Math.floor(canvas_h/units_y);

var total_rows = 23;
var total_columns = 23;
var base_column = 0;
var cur_row = 0;
var cur_column = 0;

var head_offset = 1;

var background_color = "rgba(0,255,255,1)";

/** Creator UI Vars **/
var skin_colors = ["rgba(255,0,0,1)","rgba(255,255,0,1)","rgba(0,255,0,1)","rgba(0,0,255,1)"];
var cur_skin_color = -1;

function init() {
	setupListeners();	

	stage = new createjs.Stage("canvas");
	var context = stage.canvas.getContext("2d"); 
	context.webkitImageSmoothingEnabled = context.mozImageSmoothingEnabled = false; 	

	drawHero();

}

function drawHero() {

	var backgroundRect = drawPixel(background_color, canvas_w, canvas_h, 0, 0);
    stage.addChild(backgroundRect);	

	// Draw sprite maps onto canvas

    for (sprite in sprites_leg_left) {
        // Draw left leg
        drawBodyPart('leg-left', sprites_leg_left, stage);
    }
    for (sprite in sprites_leg_right) {
        // Draw right leg
        drawBodyPart('leg-right', sprites_leg_right, stage);
    }

    for (sprite in sprites_body) {
        // Draw body
        drawBodyPart('body', sprites_body, stage);
    }

    for (sprite in sprites_head) {
        // Draw head
        drawBodyPart('head', sprites_head, stage);
    }

    for (sprite in sprites_hat) {
        // Draw hat
        drawBodyPart('hat', sprites_hat, stage);
    }
	
	stage.update();	
}

function drawBodyPart(body_part, sprites_array, stage, cur_row = 0, cur_column = 0, skin_color = "") {
	// TODO: Swap out these crazy maths with functions to calculate width/height of the various pieces
	switch (body_part) {
		case 'leg-left':
			cur_row = Math.floor((units_y/2) + (((sprites_body[sprite]['rows'].length)/2) - 2));
			cur_column = Math.floor((units_x/2) - (sprites_body[sprite]['rows'][0].length/2));
			break;
		case 'leg-right':
			cur_row = Math.floor((units_y/2) + (((sprites_body[sprite]['rows'].length)/2) - 2));
			cur_column = Math.floor((units_x/2) + ((sprites_body[sprite]['rows'][0].length/2) - (sprites_array[sprite]['rows'][0].length)));
			break;
		case 'body':
			// Center sprite in viewport
			cur_row = Math.floor((units_y/2) - (sprites_array[sprite]['rows'].length/2));
			cur_column = Math.floor((units_x/2) - (sprites_array[sprite]['rows'][0].length/2));
			break;
		case 'head':
			cur_row = Math.floor((units_y/2) - ((sprites_body[sprite]['rows'].length) + head_offset));
			cur_column = Math.floor((units_x/2) - (sprites_array[sprite]['rows'][0].length/2));
			if (cur_skin_color >= 0) {
				skin_color = skin_colors[cur_skin_color];
			}
			break;
		case 'hat':
			cur_row = Math.floor(((units_y)/2 - (sprites_array[sprite]['rows'].length)) - (sprites_body[sprite]['rows'].length/2 + (sprites_head[sprite]['rows'].length) - (head_offset + 5)));
			cur_column = Math.floor((units_x/2) - (sprites_array[sprite]['rows'][0].length/2));
			break;
		default:
			break;
	}
	base_column = cur_column;

	for(row in sprites_array[sprite]['rows']) {
        total_rows = sprites_array[sprite]['rows'].length;
        total_columns = total_rows;

		var primary_color = sprites_array[sprite]['primary_color'];
        var row_string = sprites_array[sprite]['rows'][row];

        for (var i = 0, len = row_string.length; i < len; i++) {
            var color_key = parseInt(row_string[i]);
            var pixel_color = sprites_array[sprite]['colors'][color_key];			

			if (body_part == 'head' && typeof skin_color !== 'undefined' && skin_color.length > 0) {
				//change skin color
				if (pixel_color == primary_color) {
					pixel_color = skin_color;
				}
			}

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
        cur_column = base_column;
    }
} 

// Handles the actual drawing of pixels to the canvas/stage
function drawPixel(color, w, h, x, y) {
	var pixel = new createjs.Shape();
    pixel.graphics.beginFill(color).drawRect(0, 0, w, h);

	pixel.x = x;
	pixel.y = y;	

	return pixel;
}

function setupListeners() {
	$('.creator-ui .skin-color a').on('click', function(e) {
		e.preventDefault();
		
		if (cur_skin_color < 0 || cur_skin_color < skin_colors.length ) {
			cur_skin_color++;
		} else {
			cur_skin_color = -1;
		}
		
		drawHero();
	});
}
