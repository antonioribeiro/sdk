var elixir = require('laravel-elixir');
var del = require('del');

elixir.extend('delete', function(src)
{
    new elixir.Task('delete', function()
    {
        elixir.Log
            .heading("Deleting files...")
            .files(src, true);

        return del(src);
    });
});

exports.getElixir = function() {
    return elixir;
};
