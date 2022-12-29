var c = document.createElement("CANVAS");
c.style.width = 200;
c.style.height = 140;
c.style.border = "1px black solid";
var ctx = c.getContext("2d");

document.getElementById("recommend-yes").onclick = function () {
    ctx.clearRect(0, 0, 200, 140);
    drawHead("#FFFF00");
    drawSmile(70, false);
    // left eye
    drawParts(80, 50, 8, "#0000FF");
    // right eye
    drawParts(120, 50, 8, "#0000FF");
    // nose
    drawParts(100, 60, 2, "#000000");
    document.getElementById("radio-buttons").appendChild(c);
}

document.getElementById("recommend-no").onclick = function () {
    ctx.clearRect(0, 0, 200, 140);
    drawHead("#FF0000");
    drawSmile(100, true);
    // left eye
    drawParts(80, 50, 8, "#0000FF");
    // right eye
    drawParts(120, 50, 8, "#0000FF");
    // nose
    drawParts(100, 60, 2, "#000000");
    document.getElementById("radio-buttons").appendChild(c);
}

function colorPart(color) {
    ctx.fillStyle = color;
    ctx.fill();
}

// TODO: define canvas size
function drawHead(color) {
    ctx.beginPath();
    ctx.arc(100, 70, 50, 0, 2 * Math.PI);
    colorPart(color);
    ctx.stroke();
}

// 8 for eye, 10 for nose
function drawParts(startx, starty, size, color) {
    ctx.beginPath();
    ctx.arc(startx, starty, size, 0, 2 * Math.PI);
    colorPart(color);
    ctx.stroke();
}

// happy 100, 70, sad 100 100
function drawSmile(starty, isSad) {
    ctx.beginPath();
    ctx.arc(100, starty, 30, 0, Math.PI, isSad);
    ctx.stroke();
}

