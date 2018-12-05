<?php
/**
 * Created by PhpStorm.
 * User: mikhail
 * Date: 05.12.18
 * Time: 8:09
 */

namespace App\Service;


use Psr\Log\LoggerInterface;

class Greeting
{
    /**
     * @var LoggerInterface
     */
    private $logger;
    
    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }
    
    public function greet(string $name): string
    {
        $this->logger->info("Greeted {$name}");
        return "Hello {$name}";
    }
}