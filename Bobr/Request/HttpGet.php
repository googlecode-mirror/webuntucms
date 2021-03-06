<?php

class Bobr_Request_HttpGet
{
	private static $isAssigned = FALSE;

	private $get = array();

    /**
     * Nazev promene do ktere se uklada lang v getu.
     *
     * @var string
     */
    const GET_LANG_VARIABLE = 'bobrlang';
    
	public function assign(array $GET)
	{
		if (FALSE === self::$isAssigned) {
            // Pokud neni nic v GETu musime tam alespon vlozit prazdnou promenou.
            if (! isset($GET[Bobr_Request_HttpRequest::GET_VARIABLE])) {
                $this->get[Bobr_Request_HttpRequest::GET_VARIABLE] = '';
            } else {
                $this->get = $GET;
            }
            $this->setLangFromUri();
			self::$isAssigned = TRUE;
		} else {
			throw new Exception('$_GET jiz byl nacten.');
		}
	}

    private function setLangFromUri()
    {
        $config = new Config;
        if ($config->remoteLangFrom === 'uri') {

            $langList = new Bobr_LangList;
            if (!empty($langList->items)) {
                $pattern = '@';
                // Vytvorime si matchovaci patternu.
                foreach ($langList->getItems() as $lang) {
                    $pattern .= $lang->symbol . '|';
                }
                // Odstranime posledni znamenko. (je to |)
                $pattern = substr($pattern, 0, -1) . '@';
                // Zjistime jestli podoporovany jazyk je v uri
                if (0 < preg_match($pattern, $this->get[Bobr_Request_HttpRequest::GET_VARIABLE], $matches)) {
                    // Vytrovime samostatnou promenou a ulozime do ni symbol jazyka.
                    $this->get[Bobr_Request_HttpGet::GET_LANG_VARIABLE] = $matches[0];

                    
                    // Odebereme z uri symbol jazyka, vadil by pri dalsi praci.
                    $this->get[Bobr_Request_HttpRequest::GET_VARIABLE] = str_replace($matches[0] . '/', '', $this->get[Bobr_Request_HttpRequest::GET_VARIABLE]);
                    print_Re($this);
                    return TRUE;
                }
                $this->get[self::GET_LANG_VARIABLE] = $config->defaultLang;
                Bobr_Request_HttpRequest::redirect($config->webRoot . $config->defaultLang . '/');
            } else {
                throw new ErrorException('Neni podpora pro jazyky.');
                //HttpRequest::redirect($config->webRoot . $config->defaultLang . '/');
            }
        }
    }

    /**
     * Vrati aktualni lang ktery je v GETu.
     * Pokud tam lang neni vrati prazdny string.
     *
     * @return string
     */
    public function getLang()
    {
        return  
            isset($this->get[Bobr_Request_HttpGet::GET_LANG_VARIABLE])
                ? $this->get[Bobr_Request_HttpGet::GET_LANG_VARIABLE]
                : '';
    }

    /**
     * Vraci vlastnost get.
     * @todo toto znicit
     *
     * @return array
     */
    public function get()
    {
        return $this->get;
    }

    public function __get($name)
	{
		if (isset($this->get[$name])) {
			return $this->get[$name];
		} else {
			throw new InvalidArgumentException("Promena $name neexistuje.");
		}
	}

	public function __isset($name)
	{
		return isset($this->get[$name]);
	}
}