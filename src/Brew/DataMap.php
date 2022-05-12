<?php
declare(strict_types=1);
namespace Kenjiefx\Lemonade\Brew;
use GuzzleHttp\Psr7\Uri;
use Kenjiefx\Lemonade\Exceptions\BuildDataNotFoundException;

class DataMap {

    private array $dataset = [];

    public const FAKER_PATH = '/faker/data/';

    public function __construct(
        private Uri $uri,
        private bool $isLiveBuild
        )
    {
        $this->parse();
    }

    private function parse()
    {
        parse_str($this->uri->getQuery(),$this->dataset);

    }

    public function map()
    {
        if (!$this->isLiveBuild) {
            return $this->faker();
        }
        return $this->resolve();
    }

    private function faker()
    {
        $data = [];
        try {
            foreach ($this->dataset as $key => $value) {
                $path = ROOT.DataMap::FAKER_PATH."{$key}/{$value}.json";
                if (!file_exists($path)) {
                    throw new BuildDataNotFoundException(
                        "Error::Build Target Not Found: {$path}"
                    );
                }
                $data[$key] = json_decode(file_get_contents($path),TRUE);
            }
        } catch (\Exception $e) {
            exit($e->getMessage());
        }
        return $data;
    }

    private function resolve()
    {
        $data = [];
        try {
            if (!isset($this->dataset['source'])) {
                throw new BuildDataNotFoundException(
                    "Error::Build Required Params {source} Not Found"
                );
            }
            if (!isset($this->dataset['look'])) {
                throw new BuildDataNotFoundException(
                    "Error::Build Required Params {look} Not Found"
                );
            }
            if (!isset($this->dataset['name'])) {
                throw new BuildDataNotFoundException(
                    "Error::Build Required Params {name} Not Found"
                );
            }
            $path = $this->dataset['look'].'/'.$this->dataset['source'];
            if (!file_exists($path)) {
                throw new BuildDataNotFoundException(
                    "Error::Build Target Not Found: {$path}"
                );
            }
            $data[$this->dataset['name']] = json_decode(file_get_contents($path),TRUE);

        } catch (\Exception $e) {
            exit($e->getMessage());
        }

        return $data;

    }

}
