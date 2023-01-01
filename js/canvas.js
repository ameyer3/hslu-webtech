var c = document.getElementById("myCanvas");
var ctx = c.getContext("2d");
ctx.clearRect(0, 0, 200, 180);
drawHead("#FFFFFF");
// left eye
drawParts(80, 50, 8, "#0000FF");
// right eye
drawParts(120, 50, 8, "#0000FF");
// nose
drawParts(100, 60, 2, "#000000");

document.getElementById("recommend-yes").onclick = function () {
    ctx.clearRect(0, 0, 200, 180);
    drawHead("#FFFF00");
    drawSmile(70, false);
    // left eye
    drawParts(80, 50, 8, "#0000FF");
    // right eye
    drawParts(120, 50, 8, "#0000FF");
    // nose
    drawParts(100, 60, 2, "#000000");
    ctx.font = "30px Arial";
    ctx.fillText("Thank you!", 30, 150);
}

document.getElementById("recommend-no").onclick = function () {
    ctx.clearRect(0, 0, 200, 180);
    drawHead("#FF0000");
    drawSmile(100, true);
    // left eye
    drawParts(80, 50, 8, "#0000FF");
    // right eye
    drawParts(120, 50, 8, "#0000FF");
    // nose
    drawParts(100, 60, 2, "#000000");
    ctx.font = "30px Arial";
    ctx.fillText("Sorry!", 60, 150);
}


function colorPart(color) {
    ctx.fillStyle = color;
    ctx.fill();
}

function drawHead(color) {
    ctx.lineWidth = 8;
    ctx.beginPath();
    ctx.arc(100, 70, 50, 0, 2 * Math.PI);
    colorPart(color);
    ctx.stroke();
    ctx.lineWidth = 1;

}

function drawParts(startx, starty, size, color) {
    ctx.beginPath();
    ctx.arc(startx, starty, size, 0, 2 * Math.PI);
    colorPart(color);
    ctx.stroke();
}

function drawSmile(starty, isSad) {
    ctx.beginPath();
    ctx.arc(100, starty, 30, 0, Math.PI, isSad);
    ctx.stroke();
}