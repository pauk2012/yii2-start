<?php
/**
 * Created by JetBrains PhpStorm.
 * User: pauk
 * Date: 12.01.15
 * Time: 12:30
 * To change this template use File | Settings | File Templates.
 */

class Vcs
{
    public $gitBin = 'GIT_EDITOR=vi /usr/bin/git';
    public $hgBin = 'HGEDITOR=vi /usr/bin/hg';
    public $result = [];

    public function scanDir($dir)
    {
        $dh = opendir($dir);

        while (false !== ($filename = readdir($dh))) {
            if ($filename == '.' || $filename == '..') {
                continue;
            }
            $filePath = $dir . '/' . $filename;
            if (!is_dir($filePath)) {
                continue;
            }
            if ($filename == 'assets') {
                continue;
            }

            $dirPath = $filePath;

            if ($filename == '.git') {
                $this->result[] = $dirPath;
                $this->vcsStatus($dir, 'git');


            } else if ($filename == '.hg') {
                $this->result[] = $dirPath;
                $this->vcsStatus($dir, 'hg');
            } else {
                $this->scanDir($dirPath);
            }



        }


    }

    public function vcsStatus($path, $vcs)
    {

        switch ($vcs){
            case'git':
                $returnDir = getcwd();
                chdir($path);
                $output = null;

                $command = $this->gitBin . ' status';
                echo $path . "\n";
                echo $command . "\n";
                passthru($command);

                chdir($returnDir);
                break;
            case'hg':
                $returnDir = getcwd();
                chdir($path);
                $command = $this->hgBin . ' status';
                echo $path . "\n";
                echo $command . "\n";
                passthru($command);

                chdir($returnDir);
                break;
            default:

        }

    }

    public function vcsCommit($path, $vcs)
    {

        switch ($vcs){
            case'git':
                $returnDir = getcwd();
                chdir($path);
                $output = null;

                $command = $this->gitBin . ' commit -a';
                echo $path . "\n";
                echo $command . "\n";
                passthru($command);

                chdir($returnDir);
                break;
            case'hg':
                $returnDir = getcwd();
                chdir($path);
                $command = $this->hgBin . ' commit';
                echo $path . "\n";
                echo $command . "\n";
                passthru($command);

                chdir($returnDir);
                break;
            default:

        }

    }


}


$dir = realpath(dirname(__FILE__));

$vcs = new Vcs;
$vcs->scanDir($dir);

//print_r($vcs->result);

