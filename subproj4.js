function result() {
	let name= document.getElementById('name').value

	let score=0

	function correct(id){
		if (document.getElementById(id).checked) {
			score++
		}
		return score
	}
	correct('b1')
	correct('a2')
	correct('c5')
	correct('d3')
	correct('e4')
if(name==" "){
return false
}
	alert(name+ ',Your score Is: ' +score)
	alert(name)
}
