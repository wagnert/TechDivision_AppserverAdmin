<?php

/**
 * Copyright (c) 2013 Simon Paarlberg
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is furnished
 * to do so, subject to the following conditions:
 * 
 * The above copyright notice and this permission notice shall be included in all
 * copies or substantial portions of the Software.
 * 
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 */
namespace TechDivision\AppserverAdmin\Utilities;

class Tail
{

    protected $storage_file;

    protected $file_list = array();

    protected $file_memory = array();

    public function __construct($storage_file)
    {
        $dirname = dirname($storage_file);
        if (! is_dir($dirname) || ! is_writable($dirname)) {
            throw new \Exception("Can't write to $dirname.");
        }
        $this->storage_file = $storage_file;
        
        if (file_exists($this->storage_file)) {
            $this->file_memory = json_decode(file_get_contents($this->storage_file), 1);
        }
    }

    public function listen($callback, $full_line = false)
    {
        if (! is_callable($callback)) {
            throw new \Exception("Invalid callback function.");
        }
        
        while (1) {
            $start_time = microtime(true);
            foreach ($this->file_list as $filename) {
                
                $filesize = filesize($filename);
                
                // If the filename is unknown, we save the present offset.
                if ($this->getFileSavedSize($filename) === - 1) {
                    $this->setFileOffset($filename, $filesize);
                    $this->setFileSavedSize($filename, $filesize);
                    continue;
                }
                
                // Check that the file hasn't scrunk.
                // If is has, reset the pointer.
                if ($this->getFileSavedSize($filename) > $filesize) {
                    $this->setFileSavedSize($filename, 0);
                }
                
                // If nothing has happened with the filesize, we do nothing..
                if ($this->getFileSavedSize($filename) == $filesize) {
                    continue;
                }
                $this->setFileSavedSize($filename, $filesize);
                
                // At this point we know the file size has expanded.
                
                // Read in the latest changes.
                $offset = $this->getFileOffset($filename);
                $content = $this->getExcerpt($filename, $offset, $filesize - $offset);
                if ($content === false || empty($content)) {
                    continue;
                }
                
                if ($full_line) {
                    
                    $x = strpos($content, "\n");
                    if ($x === false) {
                        continue;
                    }
                    
                    $content = substr($content, 0, $x + 1);
                    
                    // Update the offset of the filename
                    $this->setFileOffset($filename, $offset + strlen($content));
                    
                    $content = trim($content);
                } else {
                    
                    // Update the offset of the filename
                    $this->setFileOffset($filename, $filesize);
                }
                
                if ($callback($filename, $content) === false) {
                    break;
                }
            }
            
            // Sleep for at least half a second..
            $t = 500000 - (microtime(true) - $start_time);
            if ($t > 0) {
                usleep($t);
            }
        }
    }

    public function listenForLines($callback)
    {
        $this->listen($callback, true);
    }

    private function getExcerpt($filename, $offset, $length)
    {
        if ($length === 0) {
            return false;
        }
        
        if (($handle = @fopen($filename, 'r')) === false) {
            return false;
        }
        
        fseek($handle, $offset);
        $content = fread($handle, $length);
        fclose($handle);
        
        return $content;
    }

    private function setFileOffset($filename, $offset)
    {
        $this->file_memory[$filename]['offset'] = $offset;
        file_put_contents($this->storage_file, json_encode($this->file_memory));
    }

    private function getFileOffset($filename)
    {
        if (! isset($this->file_memory[$filename]['offset'])) {
            $this->file_memory[$filename]['offset'] = - 1;
        }
        
        return $this->file_memory[$filename]['offset'];
    }

    private function setFileSavedSize($filename, $size)
    {
        $this->file_memory[$filename]['size'] = $size;
        file_put_contents($this->storage_file, json_encode($this->file_memory));
    }

    private function getFileSavedSize($filename)
    {
        if (! isset($this->file_memory[$filename]['size'])) {
            $this->file_memory[$filename]['size'] = - 1;
        }
        
        return $this->file_memory[$filename]['size'];
    }

    public function addFile($filename)
    {
        if (! file_exists($filename) || ! is_file($filename)) {
            throw new \Exception("Could not find file: $filename.");
        }
        
        $filename = realpath($filename);
        if (! in_array($filename, $this->file_list)) {
            $this->file_list[] = $filename;
        }
        
        return $this;
    }
}