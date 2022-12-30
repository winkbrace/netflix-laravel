<?php declare(strict_types=1);

namespace Tests\Content;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Netflix\Content\Importer;
use Tests\TestCase;

class ImporterTest extends TestCase
{
    use RefreshDatabase;

    private Importer $importer;

    protected function setUp(): void
    {
        parent::setUp();

        $json = file_get_contents(__DIR__ . '/../_fixtures/rapidapi.json');
        Http::fake([
            '*' => Http::response($json),
        ]);

        $this->importer = new Importer();
    }

    public function test_it_imports(): void
    {
        $this->importer->import('cyberpunk');

        self::assertEquals(10, DB::table('videos')->count());
        self::assertEquals(20, DB::table('images')->count());
    }
}
