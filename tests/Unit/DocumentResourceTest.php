<?php

declare(strict_types=1);

test('can create document', function () {
    $client = createTestClient([
        '*/KR_Session' => [
            'sessionId' => 'test-session-id',
            'result' => ['code' => 0, 'detailed' => ''],
        ],
        '*/KR_Document' => [
            'result' => ['code' => 0, 'detailed' => ''],
        ],
    ]);

    $client->document()->create(
        personId: 'test-person-id',
        filename: 'certificate.pdf',
        base64Content: 'base64encodedcontent',
    );

    // Test passes if no exception is thrown
    expect(true)->toBeTrue();
});

test('can list documents', function () {
    $client = createTestClient([
        '*/KR_Session' => [
            'sessionId' => 'test-session-id',
            'result' => ['code' => 0, 'detailed' => ''],
        ],
        '*/KR_Document' => [
            'documents' => [
                [
                    'id' => 'doc-1',
                    'filename' => 'certificate1.pdf',
                    'filesize' => 57630,
                ],
                [
                    'id' => 'doc-2',
                    'filename' => 'certificate2.pdf',
                    'filesize' => 63722,
                    'feedbackCode' => '003 - Document content is not legible',
                ],
            ],
            'result' => ['code' => 0, 'detailed' => ''],
        ],
    ]);

    $documents = $client->document()->list('test-person-id');

    expect($documents)->toHaveCount(2)
        ->and($documents[0]->filename)->toBe('certificate1.pdf')
        ->and($documents[1]->feedbackCode)->toBe('003 - Document content is not legible');
});

test('can get document', function () {
    $client = createTestClient([
        '*/KR_Session' => [
            'sessionId' => 'test-session-id',
            'result' => ['code' => 0, 'detailed' => ''],
        ],
        '*/KR_Document' => [
            'document' => [
                'id' => 'doc-1',
                'filename' => 'certificate.pdf',
                'filesize' => 57630,
                'content' => 'base64encodedcontent',
            ],
            'result' => ['code' => 0, 'detailed' => ''],
        ],
    ]);

    $document = $client->document()->get(
        personId: 'test-person-id',
        documentId: 'doc-1',
    );

    expect($document->filename)->toBe('certificate.pdf')
        ->and($document->content)->toBe('base64encodedcontent')
        ->and($document->filesize)->toBe(57630);
});

test('can delete document', function () {
    $client = createTestClient([
        '*/KR_Session' => [
            'sessionId' => 'test-session-id',
            'result' => ['code' => 0, 'detailed' => ''],
        ],
        '*/KR_Document' => [
            'result' => ['code' => 0, 'detailed' => ''],
        ],
    ]);

    $client->document()->delete(
        personId: 'test-person-id',
        documentId: 'doc-1',
    );

    // Test passes if no exception is thrown
    expect(true)->toBeTrue();
});
