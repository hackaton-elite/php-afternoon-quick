/** @jsx React.DOM */
var React = require('react');
$ = require('jquery');
global.jQuery = $;
require('../../bower_components/bootstrap-sass/assets/javascripts/bootstrap.min');

var renderMazeHeader = function (maze) {
    var mazeHeaderOutput = '<tr>';

    for (var index = 0; index < maze.width; index++) {
        mazeHeaderOutput += '<th>' + index + '</th>';
    }

    mazeHeaderOutput += '</tr>';

    return mazeHeaderOutput;
};

var getMazeAsArray = function (maze) {
    var mazeAsArray = [];

    for (var heightIndex = 0; heightIndex < maze.height; heightIndex++) {
        mazeAsArray[heightIndex] = [];
    }

    maze.maze_points.map(function (mazePoint) {
        mazeAsArray[mazePoint.xCoordinate][mazePoint.yCoordinate] = mazePoint;
    });

    return mazeAsArray;
};

var renderMazeCell = function (mazePoint) {
    console.log('render maze', mazePoint);

    if (mazePoint.obstacle) {
        return 'X';
    }

    return ' ';
}

var renderMazeBody = function (mazeArray, maze) {
    var mazeBody = '';

    for (var heightIterator = 0; heightIterator < maze.height; heightIterator++) {
        mazeBody += '<tr>';

        for (var widthIterator = 0; widthIterator < maze.width; widthIterator++) {
            mazeBody += '<th>' + renderMazeCell(mazeArray[heightIterator][widthIterator]) + '</th>';
        }

        mazeBody += '</tr>';
    }

    return mazeBody;
}

$('#maze-generator').click(function (event) {
    event.preventDefault();

    var mazeHeader = $('#maze-header');
    var mazeBody = $('#maze-body');

    $.ajax({
        url: "/api/maze/generate",
        method: "POST",
        data: JSON.stringify({
            "startPointX": 0,
            "startPointY": 0,
            "endPointX": 8,
            "endPointY": 8,
            "brick_density": 50,
            "width": 10,
            "height": 10
        }),
        dataType: "json"
    }).done(function (maze) {
        var mazeHeaderOutput = renderMazeHeader(maze);
        mazeHeader.html(mazeHeaderOutput);

        var mazeAsArray = getMazeAsArray(maze);
        var mazeBodyOutput = renderMazeBody(mazeAsArray, maze);
        mazeBody.html(mazeBodyOutput);
    });
});
