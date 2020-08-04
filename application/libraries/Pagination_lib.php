<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Pagination_lib
{
    private $CI;

    private $curPage = 1;

	private $dataCount = 0;

	private $limit = 0;

	private $maxPageCount = 5;

	private $isFirst = false;

	private $isLast = false;

	private $isNext = true;

	private $isPrev = true;
	
    private $activeClass = "active";
    
	private $openTag = 	    '<div class="row mt10">
                                <div class="col-lg-12">
                                    <div class="dataTables_paginate paging_simple_numbers fr">
                                        <ul class="pagination">';

	private $firstTag = 		'';

	private $prevTag = 			'<li class="paginate_button page-item previous">
                                    <a href="{{url}}" class="page-link"><</a>
                                </li>';

	private $numTag = 			'<li class="paginate_button page-item {{activeClass}}">
                                    <a href="{{url}}" class="page-link">{{num}}</a>
                                </li>';

	private $nextTag = 			'<li class="paginate_button page-item next">
                                    <a href="{{url}}" class="page-link">></a>
                                </li>';

	private $lastTag = 			'';

    private $closeTag =		'           </ul>
                                    </div>
                                </div>
                            </div>';
    
    private $paging = "";
    
    public function __construct()
    {
        $this->CI =& get_instance();
    }

    public function setLimit($limit) 
    {
        $this->limit = (int)$limit;
    }

    public function setMaxPageCount($maxPageCount) 
    {
        $this->maxPageCount = (int)$maxPageCount;
    }

    public function getPaging($dataCount, $limit, $page)
    {
        $this->dataCount = $dataCount;
        $this->curPage = $page;
        $this->limit = $limit;
        
        $paging = '';

        if ($this->dataCount > 0) {
            $maxPage = ceil($this->dataCount / $this->limit);

            $paging .= $this->openTag;

			if ($this->isFirst) {
				$firstTag = $this->firstTag;
                $paging .= str_replace('{{url}}', getUri() . getParamString(array('page' => 1)), $firstTag);
            }
            
            if ($this->isPrev) {
				$prevTag = $this->prevTag;
                $prevPage = $this->curPage - 1 <= 0 ? 1 : $this->curPage - 1;
                $paging .= str_replace('{{url}}', getUri() . getParamString(array('page' => $prevPage)), $prevTag);
            }
            
            $halfMaxPageCount = $this->maxPageCount / 2;
			$startNum = $this->curPage - $halfMaxPageCount > 1 ? $this->curPage - $halfMaxPageCount : 1;
			$endNum = $this->curPage + $halfMaxPageCount > $maxPage ? $maxPage : $this->curPage + $halfMaxPageCount;
			if ($maxPage < $this->maxPageCount) {
				$startNum = 1;
				$endNum = $maxPage;
			} else {
				if ($startNum < $halfMaxPageCount && $maxPage > $this->maxPageCount) {
					$endNum = $this->maxPageCount;
				}
				if (($endNum - $startNum + 1) < $this->maxPageCount && $maxPage > $this->maxPageCount) {
					$startNum = $maxPage - $this->maxPageCount + 1;
				}
			}

			for ($num = $startNum; $num <= $endNum; $num++) {
                $numTag = $this->numTag;
                $numTag = str_replace('{{num}}', $num, $numTag);
                $numTag = str_replace('{{url}}', getUri() . getParamString(array('page' => $num)), $numTag);

				if ($num == $this->curPage) {
                    $numTag = str_replace('{{activeClass}}', $this->activeClass, $numTag); 
				} else {
                    $numTag = str_replace('{{activeClass}}', "", $numTag); 
				}
				$paging .= $numTag;
            }
            
            if ($this->isNext) {
				$nextTag = $this->nextTag;
                $nextPage = $this->curPage + 1 >= $maxPage ? $maxPage : $this->curPage + 1;
                $paging .= str_replace('{{url}}', getUri() . getParamString(array('page' => $nextPage)), $nextTag);
			}

			if ($this->isLast) {
                $lastTag = $this->lastTag;
                $paging .= str_replace('{{url}}', getUri() . getParamString(array('page' => $maxPage)), $lastTag);
			}

			$paging .= $this->closeTag;
        }

        return $paging;
    }
}