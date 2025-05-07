function result() {
	let name= document.getElementById('name').value

	let score=0

	function correct(id){
		if (document.getElementById(id).checked) {
			score++
		}
		return score
	}
	correct('a1')
	correct('b1')
	correct('c2')
	correct('d4')
	correct('e1')
if(name==" "){
return false
}
	alert(name+ ',Your score Is: ' +score)
	alert(name)
}
