$(document).ready(function(){
	var currentNumber = Math.floor(Math.random()*10);
	var score = 0;
	$("#number").html(currentNumber);
	$("#comment").html("Click higher or lower");
	$("#higher").click(function(){
		var newNumber = Math.floor(Math.random()*10);
		if(newNumber >= currentNumber){
			score++;	
			$("#comment").html("Good! score: "+score);	
		}
		else{
			$("#comment").html("Bad! score: "+score);
		}
		currentNumber = newNumber;
		$("#number").html(currentNumber);	
	});
	$("#lower").click(function(){
		var newNumber = Math.floor(Math.random()*10);
		if(newNumber <= currentNumber){
			score++;	
			$("#comment").html("Good! score: "+score);	
		}	
		else{
			$("#comment").html("Bad! score: "+score);
		}
		currentNumber = newNumber;
		$("#number").html(currentNumber);
	})
});
