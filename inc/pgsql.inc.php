<?php
/* simple pg lib, (C) Steinn E. Sigurdarson 2007, license: GPLv3 */

class pgdbi
{
	var $linkid;
	var $queryid;

	function pgdbi($h, $u, $p, $db, $li = NULL)
	{
		if (!$li)
		{
			$connstr = "";
			if ($h) $connstr .= "host=$h ";
			if ($u) $connstr .= "user=$u ";
			if ($p) $connstr .= "password=$p ";
			if ($db) $connstr .= "dbname=$db ";
			$this->linkid = pg_connect($connstr) or die ("Unable to connect:" . pg_last_error());
		}
		else
			$this->linkid = $li;

		$this->query("set client_encoding to 'LATIN1'");
	}

	function query($sql)
	{
		if ($this->queryid)
		@pg_free_result($this->queryid);

		$this->queryid = pg_query($this->linkid, $sql) or die("SQL Error: " . pg_last_error() . "<!--" . $sql . "-->");
	}

	function farr($qid = NULL)
	{
		if ($qid == NULL)
			$qid = $this->queryid;
		if (pg_num_rows($qid))
			return pg_fetch_assoc($qid);
		else
			return NULL;
	}

	function frow($qid = NULL)
	{
		if ($qid == NULL)
			$qid = $this->queryid;
		if (pg_num_rows($qid))
			return pg_fetch_row($qid);
		else
			return NULL;
	}

	function selectrow_array($query)
	{
		$this->query($query);
		return $this->farr();
	}

	function selectall_array($query)
	{
		$this->query($query);
		return $this->fetchall();
	}

	function selectcol($query, $col = 0)
	{
		$this->query($query);
		$arr = $this->frow();
		return $arr[$col];
	}

	function fetchall($qid = NULL)
	{
		$qarr = array();
		if ($qid == NULL)
			$qid = $this->queryid;

		if (pg_num_rows($qid))
		{
			while ($a = pg_fetch_assoc($qid))
				$qarr[] = $a;
			return $qarr;
		}
		else
			return NULL;
	}

	function num_rows($qid = NULL)
	{
		if ($qid == NULL)
			$qid = $this->queryid;

		return pg_num_rows($qid);
	}
}
?>
