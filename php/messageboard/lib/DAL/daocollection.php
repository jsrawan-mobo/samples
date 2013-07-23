<?php
abstract class daocollection implements Iterator
{
    protected $position = 0;
    protected $storage = array();


    /*
     *
     * Jag: Not sure if I like the getWithData, we should have our own dao collection.
     * */
    //abstract public function getwithdata();
    
    protected function populate($array, $dataobject)
    {
        customErrorHandler(E_USER_NOTICE, "daocollection::populate" , __FILE__, __LINE__);	        
        foreach ($array as $item) {
            $object = new $dataobject;
            foreach ($item as $key=>$val) {
                
                $object->$key = $val;
            }
            $this->storage[] = $object;
        }
    }

    
    public function saveall()
    {
        foreach ($this as $item) {
            $item->save();
        }
    }
    
    public function current()
    {
        return $this->storage[$this->position];
    }
    
    public function key()
    {
        return $this->position;
    }
    
    public function next()
    {
        $this->position++;
    }
    
    public function rewind()
    {
        $this->position = 0;        
    }
    
    public function valid()
    {
        return isset($this->storage[$this->position]);
    }
    
        
    public function countItems()
    {
        $myCount = count($this->storage);
        return $myCount;
    }
    
    public function getStorage()
    {
        return $this->storage;
    }    
    
    
}
?>