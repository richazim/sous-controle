<?php

test('framework is correctly installed', function(){
    expect(base_path('.env'))->toBeFile();
    expect(base_path('composer.json'))->toBeFile();
    expect(base_path('vendor'))->toBeDirectory();
});