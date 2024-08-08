<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Github: https://github.com/baymaulana16  
 */
class Datatables_ci3
{
	private $db;
	private $table;
	private $select;
	private $join;
	private $where;
	private $order;
	private $groupStatus;
	private $group;
	private $columnName;

	public function __construct()
	{
		$ci = &get_instance();
		$this->dbDefault = $ci->db;
		$this->load = $ci->load;
		$this->input = $ci->input;
	}

	/**
	 * Generate  
	 */
	public function generate($data)
    {
    	$this->db 			= (isset($data['db']) && !empty($data['db'])) ? $this->load->database($data['db'], TRUE) : $this->dbDefault;
    	$this->table 		= $data['table'];
    	$this->select 		= $data['select'];
    	$this->join 		= (isset($data['join']) && !empty($data['join'])) ? $data['join'] : FALSE;
    	$this->where 		= (isset($data['where']) && !empty($data['where'])) ? $data['where'] : FALSE;
    	$this->order 		= (isset($data['order']) && !empty($data['order'])) ? $data['order'] : FALSE;
    	$this->groupStatus 	= (isset($data['groupStatus']) && !empty($data['groupStatus'])) ? $data['groupStatus'] : FALSE;
    	$this->group 		= (isset($data['groupColumn']) && !empty($data['groupColumn'])) ? $data['groupColumn'] : FALSE;

    	return [
    		'data' 				=> $this->allData(),
    		'recordsTotal'    	=> $this->recordsTotal(),
            'recordsFiltered' 	=> $this->recordsFiltered(),
    	];
    }

    /**
	 * Data per page  
	 */
    private function allData()
    {
        $this->queryData();
        if ($this->input->post('length') != -1) 
        {
            $this->db->limit($this->input->post('length'), $this->input->post('start'));
        }
        $query = $this->db->get();
        return $query->result();
    }

    /**
	 * Filtered data  
	 */
    private function recordsFiltered()
    {
        $this->queryData();
        $query = $this->db->get();
        return $query->num_rows();
    }

    /**
	 * Overall data  
	 */
    private function recordsTotal()
    {
    	$this->fixedQuery();
        return $this->db->count_all_results();
    }

    /**
	 * Overall query 
	 */
    private function queryData()
    {
    	$this->setAlias($this->select);
    	$this->fixedQuery();
    	$this->orderData();
    	$this->searchData();
    }

    /**
	 * fixedQuery
	 */
    private function fixedQuery()
    {
    	$this->tableSelect();
        $this->joinTable();
        $this->whereData();
    	$this->groupData();
    }

    /**
	 * Query table select 
	 */
    private function tableSelect()
    {
        $this->db->select($this->select);
        $this->db->from($this->table);
    }

    /**
	 * Remove alias (as) from select data for searching 
	 */
    private function setAlias()
    {
    	$field = [];
		foreach($this->select as $select)
		{
			if(stripos($select, 'as'))
			{
				$field[] = trim(preg_replace('/(.*)\s+as\s+(\w*)/i', '$1', $select));
			}
			else
			{
				$field[] = $select;
			}
		}
    	
    	$this->columnName = $field;
	}

	/**
	 * Query join table 
	 */
    private function joinTable()
    {
        if (isset($this->join) && !empty($this->join)) 
        {
            foreach($this->join as $join) 
            {
            	if (isset($join[2])) 
            	{
	                $this->db->join($join[0], $join[1], $join[2]);
            	}
            	else
            	{
	                $this->db->join($join[0], $join[1]);
            	}
            }
        }
    }

    /**
	 * Query where data 
	 */
    private function whereData()
    {
        if (isset($this->where) && !empty($this->where)) 
        {
            $this->db->where($this->where);
        }
    }

    /**
	 * Query group data 
	 */
    private function groupData()
    {
    	if ($this->groupStatus == TRUE) 
    	{
	        if (isset($this->group) && !empty($this->group)) 
	        {
	            $this->db->group_by($this->group);
	        }
	        else
	        {
	            $this->db->group_by($this->columnName);
	        }
    	}
    }

    /**
	 * Query order data 
	 */
    private function orderData()
    {
    	if (!is_null($this->input->post('order'))) 
        {
            $this->db->order_by($this->columnName[$this->input->post('order')['0']['column']], $this->input->post('order')['0']['dir']);
        } 
        else
        {
	    	if (isset($this->order) && !empty($this->order)) 
	        {
		    	foreach($this->order as $order => $order_value) 
		        {
		            $this->db->order_by($order, $order_value);
		        }
	        }
        }
    }

    /**
	 * Query search data 
	 */
    private function searchData()
    {
        $i = 0;
        foreach ($this->columnName as $item) 
        {
            if ($this->input->post('search')['value']) 
            {
                if ($i === 0) 
                {
                    $this->db->group_start();
                    $this->db->like($item, $this->input->post('search')['value']);
                } 
                else 
                {
                    $this->db->or_like($item, $this->input->post('search')['value']);
                }

                if (count($this->columnName) - 1 == $i) 
                {
                    $this->db->group_end();
                }
            }
            $i++;
        }
    }
}

/* Location: ./application/libraries/Datatables_ci3.php */