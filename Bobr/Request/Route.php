<?php
/**
 * Description of Route
 *
 * @author rbas
 */
class Bobr_Request_Route extends Object
{
    private $id = 0;

    private $moduleFunctionId = 0;

    private $webInstanceId = 0;

	private $pageId = 0;

	private $command = '';

    private $uri = '';

    /**
     * Nacte routu z databaze, pokud neexistuje vrati NULL jinak sebe.
     *
     * @param string $uri
     * @param string $lang
     * @return Bobr_Request_Route | NULL
     */
    public function loadByUri($uri, $lang)
    {
        if (empty($lang)) {
            throw new ErrorException ('Nemam nastaven jazyk, nemuzu zjistovat o jaky druh routy se jenda.');
        }
        
        $query = "SELECT `id`, `webinstance_id`, `pageid_id`, `command`, `uri`
            FROM `" . Config::DB_PREFIX . "routestatic_" . $lang . "`
            WHERE `uri` = '" . $uri . "'
            LIMIT 1";
        $record = dibi::query($query)->fetch();
        if (!empty($record)) {
            $this->importRecord($record);
            return $this;
        } else {
            return NULL;
        }
        
    }

    public function importRecord(array $record)
    {
        if (isset($record['id'])) {
            $this->setId($record['id']);
        }

        if (isset($record['module_functions_id'])) {
            $this->setModuleFunctionId($record['module_functions_id']);
        }

        if (isset($record['webinstance_id'])) {
            $this->setWebInstanceId($record['webinstance_id']);
        }

        if (isset($record['pageid_id'])) {
            $this->setPageId($record['pageid_id']);
        }

        if (isset($record['command'])) {
            $this->setCommand($record['command']);
        }

        if (isset($record['uri'])) {
            $this->setUri($record['uri']);
        }

        return $this;
    }
    
    public function getId()
    {
        return $this->id;
    }

    /**
     * Nastavi hodnotu vlastnosti id
     *
     * @param integer $id
     * @return Bobr_Request_Route
     */
    private function setId($id)
    {
        $this->id = (integer)$id;
        return $this;
    }

	/**
	 * Vrati hodnotu vlastnosti $moduleFunctionId
	 *
	 * @param void
	 * @return integer
	 */
	public function getModuleFunctionId()
	{
		return $this->moduleFunctionId;
	}

	/**
	 * Nastavi hodnotu vlastnosti $moduleFunctionId
	 *
	 * @param integer
	 * @return Bobr_Request_Route
	 */
	private function setModuleFunctionId($moduleFunctionId)
	{
        $this->moduleFunctionId = (integer)$moduleFunctionId;
		return $this;
	}

    /**
     * Vrati hotnotu vlastnosti webInstanceId
     *
     * @return integer
     */
    public function getWebInstanceId()
    {
        return $this->webInstanceId;
    }

    /**
     * Nastavi hodnotu vlastnosti webInstanceId
     *
     * @param integer $webInstanceId
     * @return Bobr_Request_Route
     */
    private function setWebInstanceId($webInstanceId)
    {
        $this->webInstanceId = (integer)$webInstanceId;
        return $this;
    }

	/**
	 * Vrati hodnotu vlastnosti $pageId
	 *
	 * @param void
	 * @return integer
	 */
	public function getPageId()
	{
		return $this->pageId;
	}

	/**
	 * Nastavi hodnotu vlastnosti $pageId
	 *
	 * @param integer
	 * @return Bobr_Request_Route
	 */
	private function setPageId($pageId)
	{
        $this->pageId = (integer)$pageId;
		return $this;
	}

	/**
	 * Vrati hodnotu vlastnosti $command
	 *
	 * @param void
	 * @return string
	 */
	public function getCommand()
	{
		return $this->command;
	}

	/**
	 * Nastavi hodnotu vlastnosti $command
	 *
	 * @param string
	 * @return Bobr_Request_Route
	 */
	private function setCommand($command)
	{
        $this->command = (string)$command;
		return $this;
	}

    public function getUri()
    {
        return $this->uri;
    }

    /**
     * Nastavi hodnotu vlastnosti uri.
     *
     * @param string $uri
     * @return Bobr_Request_Route
     */
    private function setUri($uri)
    {
        $this->uri = (string)$uri;
        return $this;
    }
}