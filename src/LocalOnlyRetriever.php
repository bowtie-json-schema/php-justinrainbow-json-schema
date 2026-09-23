<?php

declare(strict_types=1);

namespace JsonRainbow;

use JsonSchema\Exception\ResourceNotFoundException;
use JsonSchema\Uri\Retrievers\FileGetContents;

/**
 * Only retrieves local files, such as the meta-schemas bundled with justinrainbow/json-schema.
 *
 * Bowtie runs the harness without network access, so fetching a remote URI hangs until the
 * connection times out. Schemas bowtie expects to be resolvable are provided through the
 * registry, so anything else is refused immediately.
 */
class LocalOnlyRetriever extends FileGetContents
{
    public function retrieve($uri)
    {
        if (!str_starts_with($uri, 'file://')) {
            throw new ResourceNotFoundException(sprintf('Refusing to retrieve non-local URI: %s', $uri));
        }

        return parent::retrieve($uri);
    }
}
