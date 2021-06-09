function Pagination(pageNum,RPP,num,Onclick){
		// var  RPP		= $("input[name=RPP]").val();
		// var  num        = $("input[name=num]").val();
		
		var PrevIc 		=	"img/bprv.gif";
		var FirstIc 	=	"img/bfrst.gif";
		var NextIc		=	"img/bnxt.gif";
		var LastIc		=	"img/blst.gif";
		var dPrevIc		=	"img/dprv.gif";
		var dFirstIc	=	"img/dfrst.gif";
		var dNextIc		=	"img/dnxt.gif";
		var dLastIc		=	"img/dlst.gif";
		var offset = (parseFloat(pageNum) - parseFloat(1)) * parseFloat(RPP);
		var nav  = '';
		var page =  parseFloat(pageNum) - 3;
		var upper = parseFloat(pageNum) + 3;
		// var maxPage = Math.round(parseFloat(num)/parseFloat(RPP));
		var maxPage = Math.ceil(parseFloat(num)/parseFloat(RPP));
		
		
		if(num > 0) {
			
			if(page <= 0){
				page = 1;
			}
			
			if(upper > maxPage){
				upper = maxPage;
			}
	
			// Make sure there are 7 numbers (3 before, 3 after and current
			if(parseFloat(upper) - parseFloat(page) < 6){
				
				if(upper >= maxPage){
					 dif = parseFloat(maxPage) - parseFloat(page);
					if(dif == 3){
					page = parseFloat(page) - parseFloat(3);
					}else if (dif == 4){
						page = parseFloat(page) - parseFloat(2);
					}else if (dif == 5){
						page = parseFloat(page) - parseFloat(1);
					}
					
				}else if (page <= 1){
					dif = parseFloat(upper)-parseFloat(1);
	
					if (dif == 3){
						upper = parseFloat(upper) + parseFloat(3);
					}else if (dif == 4){
						upper = parseFloat(upper) + parseFloat(2);
					}else if (dif == 5){
						upper = parseFloat(upper) + parseFloat(1);
					}
				}
			}
	
			if(page <= 0) {
				page = 1;
			}
	
			if(upper > maxPage) {
				upper = maxPage;
			}
			
			for(page; page <=  upper; page++) {
				if(page == pageNum){
					nav += " <font color='red'>"+page+"</font> ";
				}else{
					nav += " <a style='cursor:pointer;' onclick='return "+Onclick+"("+page+")'>"+page+"</a> ";
				}
			}
			if(pageNum > 1){
				page  = parseFloat(pageNum) - parseFloat(1);
				prev  = "<img border='0' src='"+PrevIc+"' onclick='return "+Onclick+"("+page+")' style='cursor:pointer;'> ";
				first = "<img border='0' src='"+FirstIc+"' onclick='return "+Onclick+"(1)'  style='cursor:pointer;'> ";
			}else{
				prev  = "<img border='0' src='"+dPrevIc+"'  style='cursor:pointer;'> ";
				first = "<img border='0' src='"+dFirstIc+"'   style='cursor:pointer;'> ";
			}
			
			if(pageNum < maxPage && upper <= maxPage) {
				page = parseFloat(pageNum) + parseFloat(1);
				next = " <img border='0' src='"+NextIc+"' style='cursor:pointer;' onclick='return "+Onclick+"("+page+")'  >";
				last = " <img border='0' src='"+LastIc+"' style='cursor:pointer;' onclick='return "+Onclick+"("+maxPage+")' >";
			}else{
				next = " <img border='0' src='"+dNextIc+"' style='cursor:pointer;'>";
				last = " <img border='0' src='"+dLastIc+"' style='cursor:pointer;'>";
			}

			if(maxPage >= 1){
				return  first + prev + nav + next + last;
			}
		}
}


function numberWithCommas(x) {
    var parts = x.toString().split(".");
    parts[0] = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    return parts.join(".");
}