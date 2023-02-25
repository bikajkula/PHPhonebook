	function fja(){
	var request=new XMLHttpRequest();
	request.open('GET','../imenik.json',true);
	request.onload = function() {
	  var data=JSON.parse(this.response);
	  for(var i=0;i<data.length;i++){
		  console.log(data[i].ime+' '+data[i].prezime);
	  }
	}
	request.send();
	console.log("dsadsada");
	}
	
