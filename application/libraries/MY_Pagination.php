<?php
# Pagination (PHP5)
#
# pakage: 	Reza CMSpro
# date: 	1390-2-26
# version: 	2.0
# author: 	Reza Sh (www.RezaOnline.Net/Blog)
# email: 	Reza19sh@gmail.com
# license: 	gpl

class MY_Pagination{

	private $all 	= 	0;		// select count(id) from post where status=publish
	private $range 	=	10;		// max post per page
	private $inpage	=	0;		// current page
	private $url=	'';			// url of page like http://mysite.com/page-
	private $after_url =	'';	// character for end of url like .html
	private $limit	   = null;	// make limit like 3 show 1 , 2 , 3 , ... , 5 , 6 , 7 , ... , 18 , 19 , 20
	
	// for example : http://mysite.com/page-1.html
	
			/**
		* construct func
		* get pagenumbers config
		*
		* @param $conf array 
		*/
	function __construct($conf=null)
	{
		if(!is_array($conf))
			return '';
			
			if(isset($conf['all']) && !empty($conf['all']))
				$this->all = $conf['all'];
			
			if(isset($conf['range']) && !empty($conf['range']))
				$this->range = $conf['range'];
			
			if(isset($conf['inpage']) && !empty($conf['inpage']))
				$this->inpage = $conf['inpage'];
			
			if(isset($conf['url']) && !empty($conf['url']))
				$this->url = $conf['url'];
			
			if(isset($conf['after_url']) && !empty($conf['after_url']))
				$this->after_url = $conf['after_url'];
				
			if(isset($conf['limit']) && !empty($conf['limit']))
				$this->limit = $conf['limit'];
	}
		/**
	* Return str class=inpage where page num is in page
	*
	* @access	private
	* @param $i int
	* @param $inpage string
	* @return string
	*/
	private function inpage($i,$inpage)
	{
		if($i==$inpage)
			return ' class="inpage"';
		return '';	
	}
	
		/**
	* check the number zoj or fard
	*
	* @access	private
	* @param $i int
	* @return bool
	*/
	private function is_zoj($int=1)
	{
		if($int%2 ==0)
			return true;
		return false;
	}
	
		/**
	* show page numbers
	*
	* @access	public
	* @return string - list of page numbers
	*/
	public function pagenumber()
	{
	$inpage = $this->inpage;
	$limit =$this->limit;
	$maxitem = ceil($this->all/$this->range);
	$last_end = $maxitem - $limit;
		$i = $fir_out = $sec_out = 0;
		
			// start of pagenumber
      $out="\n<ul class='pagenumber'>\n";
	  if(1<$inpage )	
		$out.='<li><a href="'.$this->url.'1'.$this->after_url.'" target="_self" rel="nofllow" >صفحه اول</a></li>'."\n".'<li><a href="'.$this->url.($inpage-1).$this->after_url.'" target="_self" rel="nofllow" >صفحه قبل</a></li>'."\n";
    
			//loop of pagenumber
	  while ($i<$maxitem)
	  {
		$i++;
			if($limit === null or ($i<=$limit) or ($i>$last_end) or ($i==$inpage) or ($i> $inpage-ceil(($limit)/2) and $i < $inpage+ceil(($limit)/2)) or ($this->is_zoj($limit) and $i>= $inpage-ceil(($limit)/2) and $i < $inpage+ceil(($limit)/2)) )
				$out.='<li'.$this->inpage($i,$inpage).'><a href="'.$this->url.$i.$this->after_url.'" target="_self" rel="nofllow" >'.$i.'</a></li>'."\n";
			elseif($i>$limit && ((!$this->is_zoj($limit) and $i<$inpage-(($limit)/2) ) or ($this->is_zoj($limit) and $i<$inpage-($limit/2)) ))
				$fir_out++;
			elseif($i<=$maxitem-$limit &&( (!$this->is_zoj($limit) and $i>$inpage-(($limit-1)/2)) or ($this->is_zoj($limit) and $i>$inpage+($limit/2)-1) ))
				$sec_out++;
			else
				continue;
							
				//show doted
				if($fir_out ===1 and ( (!$this->is_zoj($limit) and $i<$inpage-(($limit)/2)) or ($this->is_zoj($limit) and $i<$inpage-($limit/2)) ) )
					$out.='<li class="dotedli">...</li>';		
				elseif($sec_out===1 &&( (!$this->is_zoj($limit) and $i>$inpage-(($limit-1)/2) ) or ($this->is_zoj($limit) and $i>$inpage+($limit/2)-1) ) && $i<$maxitem-$limit+1)
					$out.='<li class="dotedli">...</li>';
				else
					continue;
						
			 }
	 		// end of pagenumber
	if($maxitem>$inpage )	
		$out.='<li><a href="'.$this->url.($inpage+1).$this->after_url.'"  >صفحه بعد</a></li>'."\n".'<li><a href="'.$this->url.$i.$this->after_url.'" target="_self" rel="nofollow" >صفحه آخر</a></li>'."\n"; 

		$out.="</ul>\n<div style='clear:both'></div>";		
			if($i===1)
				return '';
		return $out;
	}
	
	
	function __destruct()
	{
		// end
	}
}


