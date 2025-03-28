<?php

test('The framework is correctly installed (ie: required folder (vendor) and files (composer.json, .env) are present)', function(){
    expect(base_path('.env'))->toBeFile();
    expect(base_path('composer.json'))->toBeFile();
    expect(base_path('vendor'))->toBeDirectory();
});