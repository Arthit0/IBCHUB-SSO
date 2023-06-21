<?php
class db {
    protected $qb_select			= array();
    protected $qb_where			= array();
    protected $qb_groupby			= array();
    protected $qb_having			= array();
    protected $qb_from			= array();
    protected $qb_join			= array();
    protected $qb_keys			= array();
    public $queries			= array();
    protected $qb_limit			= FALSE;
    protected $qb_offset			= FALSE;
    protected $qb_orderby			= array();
    protected $qb_distinct			= array();
    protected $_random_keyword = array('RAND()', 'RAND(%d)');
    protected $_like_escape_str = " ESCAPE '%s' ";
    protected $_like_escape_chr = '!';

    public $test_q			= 1234;
    function __construct() {

    }

    function select($select = '*') {
      if (is_string($select))
      {
        $select = explode(',', $select);
      }

      // If the escape value was not set, we will base it on the global setting
      // is_bool($escape) OR $escape = $this->_protect_identifiers;

      foreach ($select as $val)
      {
        $val = trim($val);

        if ($val !== '')
        {
          $this->qb_select[] = $val;
          // $this->qb_no_escape[] = $escape;

        }
      }

      return $this;
    }

    public function from($from)
  	{
  		foreach ((array) $from as $val)
  		{

  				$val = trim($val);

  				// Extract any aliases that might exist. We use this information
  				// in the protect_identifiers to know whether to add a table prefix

  				$this->qb_from[] = $val ;

  		}

  		return $this;
  	}

    public function where($key, $value = NULL, $escape = NULL)
    {
      return $this->_wh('qb_where', $key, $value, 'AND ', $escape);
    }
    protected function _limit($sql)
  	{
  		return $sql.' LIMIT '.($this->qb_offset ? $this->qb_offset.', ' : '').(int) $this->qb_limit;
  	}



    protected function _wh($qb_key, $key, $value = NULL, $type = 'AND ', $escape = NULL)
    {
      // $qb_cache_key = ($qb_key === 'qb_having') ? 'qb_cache_having' : 'qb_cache_where';

      if ( ! is_array($key))
      {
        $key = array($key => $value);
      }

      // If the escape value was not set will base it on the global setting
      // is_bool($escape) OR $escape = $this->_protect_identifiers;

      foreach ($key as $k => $v)
      {
        // $prefix = (count($this->$qb_key) === 0 && count($this->$qb_cache_key) === 0)
        //   ? $this->_group_get_type('')
        //   : $this->_group_get_type($type);

        if ($v !== NULL)
        {
          if ($escape === TRUE)
          {
            $v = $this->escape($v);
          }

          if ( ! $this->_has_operator($k))
          {
            $k .= ' = ';
          }
        }
        elseif ( ! $this->_has_operator($k))
        {
          // value appears not to have been set, assign the test to IS NULL
          $k .= ' IS NULL';
        }
        elseif (preg_match('/\s*(!?=|<>|\sIS(?:\s+NOT)?\s)\s*$/i', $k, $match, PREG_OFFSET_CAPTURE))
        {
          $k = substr($k, 0, $match[0][1]).($match[1][0] === '=' ? ' IS NULL' : ' IS NOT NULL');
        }

        ${$qb_key} = array('condition' => $k, 'value' => $v, 'escape' => $escape);
        $this->{$qb_key}[] = ${$qb_key};


      }

      return $this;
    }
    public function limit($value, $offset = 0)
  	{
  		is_null($value) OR $this->qb_limit = (int) $value;
  		empty($offset) OR $this->qb_offset = (int) $offset;

  		return $this;
  	}
    public function order_by($orderby, $direction = '', $escape = NULL)
    {
      $direction = strtoupper(trim($direction));

      if ($direction === 'RANDOM')
      {
        $direction = '';

        // Do we have a seed value?
        $orderby = ctype_digit((string) $orderby)
          ? sprintf($this->_random_keyword[1], $orderby)
          : $this->_random_keyword[0];
      }
      elseif (empty($orderby))
      {
        return $this;
      }
      elseif ($direction !== '')
      {
        $direction = in_array($direction, array('ASC', 'DESC'), TRUE) ? ' '.$direction : '';
      }




        $qb_orderby = array();
        foreach (explode(',', $orderby) as $field)
        {
          $qb_orderby[] = ($direction === '' && preg_match('/\s+(ASC|DESC)$/i', rtrim($field), $match, PREG_OFFSET_CAPTURE))
            ? array('field' => ltrim(substr($field, 0, $match[0][1])), 'direction' => ' '.$match[1][0], 'escape' => TRUE)
            : array('field' => trim($field), 'direction' => $direction, 'escape' => TRUE);
        }


      $this->qb_orderby = array_merge($this->qb_orderby, $qb_orderby);


      return $this;
    }
    public function join($table, $cond, $type = '', $escape = NULL)
  	{
  		if ($type !== '')
  		{
  			$type = strtoupper(trim($type));

  			if ( ! in_array($type, array('LEFT', 'RIGHT', 'OUTER', 'INNER', 'LEFT OUTER', 'RIGHT OUTER'), TRUE))
  			{
  				$type = '';
  			}
  			else
  			{
  				$type .= ' ';
  			}
  		}


  		if ( ! $this->_has_operator($cond))
  		{
  			$cond = ' USING ('.($cond).')';
  		}
  		elseif ($escape === FALSE)
  		{
  			$cond = ' ON '.$cond;
  		}
  		else
  		{
  			// Split multiple conditions
  			if (preg_match_all('/\sAND\s|\sOR\s/i', $cond, $joints, PREG_OFFSET_CAPTURE))
  			{
  				$conditions = array();
  				$joints = $joints[0];
  				array_unshift($joints, array('', 0));

  				for ($i = count($joints) - 1, $pos = strlen($cond); $i >= 0; $i--)
  				{
  					$joints[$i][1] += strlen($joints[$i][0]); // offset
  					$conditions[$i] = substr($cond, $joints[$i][1], $pos - $joints[$i][1]);
  					$pos = $joints[$i][1] - strlen($joints[$i][0]);
  					$joints[$i] = $joints[$i][0];
  				}
  			}
  			else
  			{
  				$conditions = array($cond);
  				$joints = array('');
  			}

  			$cond = ' ON ';
  			for ($i = 0, $c = count($conditions); $i < $c; $i++)
  			{
  				$operator = $this->_get_operator($conditions[$i]);
  				$cond .= $joints[$i];
  				$cond .= preg_match("/(\(*)?([\[\]\w\.'-]+)".preg_quote($operator)."(.*)/i", $conditions[$i], $match)
  					? $match[1].$match[2].$operator.$match[3]
  					: $conditions[$i];
  			}
  		}

  		// Do we want to escape the table name?


  		// Assemble the JOIN statement
  		$this->qb_join[] = $join = $type.'JOIN '.$table.$cond;

  		return $this;
  	}


    public function get($table = '', $limit = NULL, $offset = NULL)
    {
      if ($table !== '')
      {

        $this->from($table);
      }

      if ( ! empty($limit))
      {
        $this->limit($limit, $offset);
      }
      $result = $this->_compile_select();
      // $result = $this->query($result);
      $this->_reset_select();
      return $result;
    }
    protected function _has_operator($str)
  	{
  		return (bool) preg_match('/(<|>|!|=|\sIS NULL|\sIS NOT NULL|\sEXISTS|\sBETWEEN|\sLIKE|\sIN\s*\(|\s)/i', trim($str));
  	}
    protected function _get_operator($str)
    {
  static $_operators;

  if (empty($_operators))
  {
    $_les = ($this->_like_escape_str !== '')
      ? '\s+'.preg_quote(trim(sprintf($this->_like_escape_str, $this->_like_escape_chr)), '/')
      : '';
    $_operators = array(
      '\s*(?:<|>|!)?=\s*',             // =, <=, >=, !=
      '\s*<>?\s*',                     // <, <>
      '\s*>\s*',                       // >
      '\s+IS NULL',                    // IS NULL
      '\s+IS NOT NULL',                // IS NOT NULL
      '\s+EXISTS\s*\(.*\)',        // EXISTS(sql)
      '\s+NOT EXISTS\s*\(.*\)',    // NOT EXISTS(sql)
      '\s+BETWEEN\s+',                 // BETWEEN value AND value
      '\s+IN\s*\(.*\)',            // IN(list)
      '\s+NOT IN\s*\(.*\)',        // NOT IN (list)
      '\s+LIKE\s+\S.*('.$_les.')?',    // LIKE 'expr'[ ESCAPE '%s']
      '\s+NOT LIKE\s+\S.*('.$_les.')?' // NOT LIKE 'expr'[ ESCAPE '%s']
    );

  }

  return preg_match('/'.implode('|', $_operators).'/i', $str, $match)
    ? $match[0] : FALSE;
}

protected function _compile_select($select_override = FALSE)
{
  // Combine any cached components with the current statements


  // Write the "select" portion of the query
  if ($select_override !== FALSE)
  {
    $sql = $select_override;
  }
  else
  {
    $sql = ( ! $this->qb_distinct) ? 'SELECT ' : 'SELECT DISTINCT ';

    if (count($this->qb_select) === 0)
    {
      $sql .= '*';
    }
    else
    {
      // Cycle through the "select" portion of the query and prep each column name.
      // The reason we protect identifiers here rather than in the select() function
      // is because until the user calls the from() function we don't know if there are aliases
      foreach ($this->qb_select as $key => $val)
      {
        $no_escape = isset($this->qb_no_escape[$key]) ? $this->qb_no_escape[$key] : NULL;
        $this->qb_select[$key] = $val;
      }

      $sql .= implode(', ', $this->qb_select);
    }
  }

  // Write the "FROM" portion of the query
  if (count($this->qb_from) > 0)
  {
    $sql .= "\nFROM ".$this->_from_tables();
  }

  // Write the "JOIN" portion of the query
  if (count($this->qb_join) > 0)
  {
    $sql .= "\n".implode("\n", $this->qb_join);
  }

  $sql .= $this->_compile_wh('qb_where')
    .$this->_compile_group_by()
    .$this->_compile_wh('qb_having')
    .$this->_compile_order_by(); // ORDER BY

  // LIMIT
  if ($this->qb_limit !== FALSE OR $this->qb_offset)
  {
    return $this->_limit($sql."\n");
  }

  return $sql;
}
protected function _from_tables()
{
  return implode(', ', $this->qb_from);
}
protected function _compile_wh($qb_key)
{
  if (count($this->$qb_key) > 0)
  {
    for ($i = 0, $c = count($this->$qb_key); $i < $c; $i++)
    {
      // Is this condition already compiled?
      if (is_string($this->{$qb_key}[$i]))
      {
        continue;
      }
      elseif ($this->{$qb_key}[$i]['escape'] === FALSE)
      {
        $this->{$qb_key}[$i] = $this->{$qb_key}[$i]['condition'].(isset($this->{$qb_key}[$i]['value']) ? ' '.$this->{$qb_key}[$i]['value'] : '');
        continue;
      }

      // Split multiple conditions
      $conditions = preg_split(
        '/((?:^|\s+)AND\s+|(?:^|\s+)OR\s+)/i',
        $this->{$qb_key}[$i]['condition'],
        -1,
        PREG_SPLIT_DELIM_CAPTURE | PREG_SPLIT_NO_EMPTY
      );

      for ($ci = 0, $cc = count($conditions); $ci < $cc; $ci++)
      {
        if (($op = $this->_get_operator($conditions[$ci])) === FALSE
          OR ! preg_match('/^(\(?)(.*)('.preg_quote($op, '/').')\s*(.*(?<!\)))?(\)?)$/i', $conditions[$ci], $matches))
        {
          continue;
        }

        // $matches = array(
        //	0 => '(test <= foo)',	/* the whole thing */
        //	1 => '(',		/* optional */
        //	2 => 'test',		/* the field name */
        //	3 => ' <= ',		/* $op */
        //	4 => 'foo',		/* optional, if $op is e.g. 'IS NULL' */
        //	5 => ')'		/* optional */
        // );

        if ( ! empty($matches[4]))
        {
          $this->_is_literal($matches[4]) OR $matches[4] = $this->protect_identifiers(trim($matches[4]));
          $matches[4] = ' '.$matches[4];
        }

        $conditions[$ci] = $matches[1].trim($matches[2])
          .' '.trim($matches[3]).$matches[4].$matches[5];
      }

      $this->{$qb_key}[$i] = implode('', $conditions).(isset($this->{$qb_key}[$i]['value']) ? ' '.$this->{$qb_key}[$i]['value'] : '');
    }

    return ($qb_key === 'qb_having' ? "\nHAVING " : "\nWHERE ")
      .implode("\n", $this->$qb_key);
  }

  return '';
}
protected function _compile_group_by()
{
  if (count($this->qb_groupby) > 0)
  {
    for ($i = 0, $c = count($this->qb_groupby); $i < $c; $i++)
    {
      // Is it already compiled?
      if (is_string($this->qb_groupby[$i]))
      {
        continue;
      }

      $this->qb_groupby[$i] = ($this->qb_groupby[$i]['escape'] === FALSE OR $this->_is_literal($this->qb_groupby[$i]['field']))
        ? $this->qb_groupby[$i]['field']
        : $this->qb_groupby[$i]['field'];
    }

    return "\nGROUP BY ".implode(', ', $this->qb_groupby);
  }

  return '';
}
protected function _compile_order_by()
{
  if (empty($this->qb_orderby))
  {
    return '';
  }

  for ($i = 0, $c = count($this->qb_orderby); $i < $c; $i++)
  {
    if (is_string($this->qb_orderby[$i]))
    {
      continue;
    }

    if ($this->qb_orderby[$i]['escape'] !== FALSE && ! $this->_is_literal($this->qb_orderby[$i]['field']))
    {
      $this->qb_orderby[$i]['field'] = $this->qb_orderby[$i]['field'];
    }

    $this->qb_orderby[$i] = $this->qb_orderby[$i]['field'].$this->qb_orderby[$i]['direction'];
  }

  return "\nORDER BY ".implode(', ', $this->qb_orderby);
}
public function escape($str)
	{
		if (is_array($str))
		{
			$str = array_map(array(&$this, 'escape'), $str);
			return $str;
		}
		elseif (is_string($str) OR (is_object($str) && method_exists($str, '__toString')))
		{
			return "'".$this->escape_str($str)."'";
		}
		elseif (is_bool($str))
		{
			return ($str === FALSE) ? 0 : 1;
		}
		elseif ($str === NULL)
		{
			return 'NULL';
		}

		return $str;
	}
  protected function _is_literal($str)
	{
		$str = trim($str);

		if (empty($str) OR ctype_digit($str) OR (string) (float) $str === $str OR in_array(strtoupper($str), array('TRUE', 'FALSE'), TRUE))
		{
			return TRUE;
		}

		static $_str;

		if (empty($_str))
		{
			$_str = array("'");
		}

		return in_array($str[0], $_str, TRUE);
	}
  public function escape_str($str, $like = FALSE)
	{
		if (is_array($str))
		{
			foreach ($str as $key => $val)
			{
				$str[$key] = $this->escape_str($val, $like);
			}

			return $str;
		}

		$str = $this->_escape_str($str);

		// escape LIKE condition wildcards
		if ($like === TRUE)
		{
			return str_replace(
				array($this->_like_escape_chr, '%', '_'),
				array($this->_like_escape_chr.$this->_like_escape_chr, $this->_like_escape_chr.'%', $this->_like_escape_chr.'_'),
				$str
			);
		}

		return $str;
	}
  protected function _reset_run($qb_reset_items)
  {
    foreach ($qb_reset_items as $item => $default_value)
    {
      $this->$item = $default_value;
    }
  }
  protected function _reset_select()
  {
    $this->_reset_run(array(
      'qb_select'		=> array(),
      'qb_from'		=> array(),
      'qb_join'		=> array(),
      'qb_where'		=> array(),
      'qb_groupby'		=> array(),
      'qb_having'		=> array(),
      'qb_orderby'		=> array(),
      'qb_aliased_tables'	=> array(),
      'qb_no_escape'		=> array(),
      'qb_distinct'		=> FALSE,
      'qb_limit'		=> FALSE,
      'qb_offset'		=> FALSE
    ));
  }
}



 ?>
