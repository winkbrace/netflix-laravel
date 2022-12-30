<?php declare(strict_types=1);

namespace Netflix\Content;

use Illuminate\Support\Facades\Http;
use Symfony\Component\Console\Style\OutputStyle;

/**
 * This class is responsible for importing netflix movies and series into a local database.
 * This is required because in the freemium version there is a tiny request limit.
 */
final class Importer
{
    private OutputStyle $output;

    public function importAll(OutputStyle $output): void
    {
        $this->output = $output;

        foreach (['cyberpunk', 'western', 'girls', 'fantasy', 'history'] as $search) {
            $this->import($search);
        }
    }

    public function import(string $search): void
    {
        $titles = $this->extract($search);
        $this->load($titles);

        $this->output->text(count($titles) . " videos inserted for search query '$search'.");
    }

    private function extract(string $search): array
    {
        $response = Http::withHeaders([
            'X-RapidAPI-Key' => config('netflix.api.key'),
            'X-RapidAPI-Host' => config('netflix.api.host'),
        ])->get(config('netflix.api.search_url'), [
            'query' => $search,
            'offset' => '0',
            'limit_titles' => '100',
            'lang' => 'en'
        ]);

        return $response->json()['titles'];
    }

    private function load(array $titles): void
    {
        foreach ($titles as $title) {
            $data = $title['jawSummary'];

            if (Video::where(['netflix_id' => $data['id']])->exists()) {
                continue;
            }

            $video = Video::create([
                'netflix_id' => $data['id'],
                'type' => $data['type'],
                'name' => $data['title'],
                'release_year' => $data['releaseYear'],
                'synopsis' => $data['synopsis'],
                'genres' => $this->toCsv($data['genres']),
                'tags' => $this->toCsv($data['tags']),
            ]);

            $this->addImage($video, $data['logoImage'], ImageType::LOGO);
            $this->addImage($video, $data['backgroundImage'], ImageType::BACKGROUND);
        }
    }

    private function toCsv(array $items): string
    {
        return collect($items)
            ->map(fn ($item) => $item['name'])
            ->implode(',');
    }

    private function addImage(Video $video, array $image, ImageType $type): void
    {
        $video->images()->create([
            'type' => $type,
            'url' => $image['url'],
            'width' => $image['width'],
            'height' => $image['height'],
        ]);
    }


}
