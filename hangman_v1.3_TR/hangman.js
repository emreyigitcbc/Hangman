function drawAll(){
	platform();
	head();
	leftEye();
	rightEye();
	body();
	leftArm();
	rightArm();
	leftLeg();
	rightLeg();
}

function platform(){
	var getcanvas = document.getElementById("man");
	var c = getcanvas.getContext("2d");
	c.moveTo(50,200); // body
	c.lineTo(50,20);
	c.stroke();
	c.moveTo(50,20); // top-right
	c.lineTo(120,20);
	c.stroke();
	c.moveTo(120,20); // top-head
	c.lineTo(120,50);
	c.stroke();
	c.moveTo(20,230); // left
	c.lineTo(50,200);
	c.stroke();
	c.moveTo(80,230); // right
	c.lineTo(50,200);
	c.stroke();
	c.moveTo(20,230); // left
	c.lineTo(80,230);
	c.stroke();
}

function head(){
	var getcanvas = document.getElementById("man");
	var k = getcanvas.getContext("2d");
	k.beginPath(); // head
	k.arc(120,70,20,0,2*Math.PI); 
	k.stroke();
}

function leftEye(){
	var getcanvas = document.getElementById("man");
	var le = getcanvas.getContext("2d");
	le.beginPath(); // left-eye
	le.arc(125,70,3,0,2*Math.PI); 
	le.stroke();
}

function rightEye(){
	var getcanvas = document.getElementById("man");
	var re = getcanvas.getContext("2d");
	re.beginPath(); // right-eye
	re.arc(115,70,3,0,2*Math.PI); 
	re.stroke();
}

function body(){
	var getcanvas = document.getElementById("man");
	var g= getcanvas.getContext("2d");
	g.moveTo(120,90); // body
	g.lineTo(120,180);
	g.stroke();
}

function leftArm(){
	var getcanvas = document.getElementById("man");
	var sok = getcanvas.getContext("2d");
	sok.moveTo(120,110); // left arm
	sok.lineTo(145,145);
	sok.stroke();
}

function rightArm(){
	var getcanvas = document.getElementById("man");
	var sak = getcanvas.getContext("2d");
	sak.moveTo(120,110); // right arm
	sak.lineTo(95,145);
	sak.stroke();
}

function leftLeg(){
	var getcanvas = document.getElementById("man");
	var soa = getcanvas.getContext("2d");
	soa.moveTo(120,180); // left leg
	soa.lineTo(95,215);
	soa.stroke();
}

function rightLeg(){
	var getcanvas = document.getElementById("man");
	var saa = getcanvas.getContext("2d");
	saa.moveTo(120,180); // right leg
	saa.lineTo(145,215);
	saa.stroke();
}