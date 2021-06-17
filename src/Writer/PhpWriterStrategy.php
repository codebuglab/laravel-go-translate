<?php

namespace CodeBugLab\GoTranslate\Writer;

use CodeBugLab\GoTranslate\File\PhpFile;

class PhpWriterStrategy extends PhpFile implements WriterStrategyInterface
{

    public function writing(string $filePath, array $translatedFile)
    {
        file_put_contents($filePath, '<?php return ' . var_export($translatedFile, true) . ';');
    }
}
