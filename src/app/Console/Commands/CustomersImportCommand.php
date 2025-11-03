<?php

namespace App\Console\Commands;

use App\Traits\ImportHelper;
use Illuminate\Console\Command;
use Illuminate\Support\LazyCollection;

class CustomersImportCommand extends Command
{

    use ImportHelper;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:customers';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import customers from CSV file.';

    /**
     * Execute the console command.
     */
    public function handleImport($filePath): void
    {
        $now = now()->format('Y-m-d H:i:s');

        LazyCollection::make(function () use ($filePath) {
            $handle = fopen($filePath, 'rb');
            fgetcsv($handle);

            while (($line = fgetcsv($handle)) !== false) {
                yield $line;
            }

            fclose($handle);
        })
        ->filter(fn ($row) => $this->validateFields($row))
        ->chunk(1000)
        ->each(function ($chunk) use ($now) {

            $values = $chunk->flatMap(fn ($row) => [$row[0], $row[1], $row[2], $row[3], $row[4], $row[5], $row[6], $now, $now])->all();
            $stmt = $this->prepareChunkedStatement($chunk->count());
            $stmt->execute($values);
        });
        
        
    }

    private function validateFields($row): bool{
        
        $validateCustomer = $this->validateCustomer($row[0]);
        if(!$validateCustomer) {
            return false;
        }
        
        $validateName = $this->validateName($row[1]);
        if(!$validateName) {
            return false;
        }
        
        $validateEmail = $this->validateEmail($row[2]);
        if(!$validateEmail) {
            return false;
        }
        
        $validateCompany = $this->validateCompany($row[3]);
        if($validateCompany) {
            return false;
        }
        
        $validateCity = $this->validateCity($row[4]);
        if(!$validateCity) {
            return false;
        }
        
        $validateCountry = $this->validateCountry($row[5]);
        if(!$validateCountry) {
            return false;
        }

        $validateBirthday = $this->validateBirthday($row[6]);
        if(!$validateBirthday) {
            return false;
        }
    
        return true;
    }

    private function validateCustomer($id): bool
    {
        if(empty($id)) {
            return false;
        }

        return true;
    }
    
    private function validateName($name): bool
    {
        if(empty($name)) {
            return false;
        }

        return true;
    }
    
    private function validateEmail($email): bool
    {
        $validEmail = filter_var($email, FILTER_VALIDATE_EMAIL);

        if(!$validEmail) {
            return false;
        }

        return true;
    }

    private function validateCompany($company): bool
    {
        if(empty($company)) {
            return false;
        }

        return true;
    }
    
    private function validateCity($city): bool
    {
        if(empty($city)) {
            return false;
        }

        return true;
    }
    
    private function validateCountry($country): bool
    {
        if(empty($country)) {
            return false;
        }

        return true;
    }

    private function validateBirthday($birthday): bool
    {
        if(empty($birthday)) {
            return false;
        }

        return true;
    }
}
