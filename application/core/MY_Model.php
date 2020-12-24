<?php

class MY_model extends CI_model
{
	public function __construct()
	{
		parent::__construct();
	}

/*---------------------------------------------------------------------*/
    
    // get configuration of the site :D
    
    public function site_config ()
    {
        //$a = array();
        //$this->db->select('option_name, option_value');
        //$this->db->where('autoload','yes');
        //$q = $this->db->get('settings');
        $q = $this->select('settings',array('autoload'=>'yes'));

        foreach ($q->result_array() as $k => $v)
        {
            //$a[$v['option_name']] = $v['option_value'];
            
            $this->config->set_item($v['option_name'], $v['option_value']);
        }
        $q->free_result();
    }

/*---------------------------------------------------------------------*/

    public function insert ($table,$data)
    {
        if (!is_array($data))
        {
            return FALSE;
        }
        return $this->db->insert($table,$data);
    }
    
/*---------------------------------------------------------------------*/

    public function select ($table,$where="",$orderBy="",$length="",$start="")
    {
        if ($where != "")
        {
            $this->db->where($where);
        }
        if (is_array($orderBy) && $orderBy != "")
        {
            $this->db->order_by($orderBy[0],$orderBy[1]);
        }
        if ($length != "")
        {
            if ($start != "")
            {
                $this->db->limit($length,$start);
            }
            else
            {
                $this->db->limit($length);
            }
        }
        $q = $this->db->get($table);
        return $q;
    }
/*---------------------------------------------------------------------*/

    public function update ($table,$set,$where)
    {
        $this->db->where($where);
        return $this->db->update($table,$set);
    }

/*---------------------------------------------------------------------*/

    public function delete($table,$where)
    {
        $this->db->where($where);
        return $this->db->delete($table);
    }

/*---------------------------------------------------------------------*/

    public function search ($str,$table,$col,$where='',$orderBy='',$length='',$start='')
    {
        /*
        // this query is important to MATCH AGAINST work
        ALTER TABLE my_links ADD FULLTEXT (title,slug)
        */
        
        $tbl_array = (is_array($col))? $col : explode(",",$col);
        $str_array = (is_array($str))? $str : explode(" ",$str);

        $this->db->group_start();
            if (is_array($where))
            {
                $this->db->where($where);
            }
            $this->db->group_start();
                if (version_compare(PHP_VERSION, '7.4', '>='))
                {
                    $imploded = implode(',', $col);
                }
                else 
                {
                    $imploded = implode($col, ',');
                }

                $this->db->where("MATCH(".$imploded.") AGAINST('$str' IN BOOLEAN MODE)", NULL, FALSE);

                foreach ($tbl_array as $key => $value)
                {
                    $col = $value;
                    foreach ($str_array as $k => $v)
                    {
                        $this->db->or_like($col,$v);
                    }
                }
            $this->db->group_end();
        $this->db->group_end();

/*      echo "<pre>";
        print_r($where);
        echo "</pre>";
*/

        if (is_array($orderBy) && $orderBy != "")
        {
            $this->db->order_by($orderBy[0],$orderBy[1]);
        }
        
        if ($length != "")
        {
            if ($start != "")
            {
                $this->db->limit($length,$start);
            }
            else
            {
                $this->db->limit($length);
            }
        }
        return $this->db->get($table);
    }

/*---------------------------------------------------------------------*/
	
}


?>