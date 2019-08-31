var polys = [];

var angle = 75;
var delta = 10;

var deltaSlider;
var angleSlider;

function windowResized(){
	resizeCanvas(window.innerWidth+18,window.innerHeight);
}

function setup() {
  var canvas=createCanvas(window.innerWidth+18, window.innerHeight);
  canvas.position(-18,0);
  canvas.style('z-index','-1');
  //angleMode(DEGREES);
  background(51);
  //deltaSlider = createSlider(0, 25, 10);
  //angleSlider = createSlider(0, 90, 75);

  var inc = 75;
  for (var x = 0; x < width; x += inc) {
    for (var y = 0; y < height; y += inc) {
      var poly = new Polygon(4);
      poly.addVertex(x, y);
      poly.addVertex(x + inc, y);
      poly.addVertex(x + inc, y + inc);
      poly.addVertex(x, y + inc);
      poly.close();
      polys.push(poly);
    }
  }
}

function draw() {
  background(59,89,152);
  angle = 60;//angleSlider.value();
  delta = (mouseX+25)/50;//deltaSlider.value();
  //console.log(angle, delta);
  //canvas.style('z-index','-1');
  for (var i = 0; i < polys.length; i++) {
    polys[i].hankin();
    polys[i].show();
  }
  //noLoop();
}

