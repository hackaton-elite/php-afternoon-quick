/** @jsx React.DOM */
var React = require('react');
$ = require('jquery');
global.jQuery = $;
require('../../bower_components/bootstrap-sass/assets/javascripts/bootstrap.min');

var renderMazeHeader = function (maze) {
    var mazeHeaderOutput = '<tr>';

    mazeHeaderOutput += '<td>&nbsp;</td>';

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

    mazeAsArray[maze.start_location.xCoordinate][maze.start_location.yCoordinate] = maze.start_location;
    mazeAsArray[maze.end_location.xCoordinate][maze.end_location.yCoordinate] = maze.end_location;

    return mazeAsArray;
};

var renderMazeCell = function (mazePoint) {
    if ('undefined' !== typeof mazePoint.obstacle && mazePoint.obstacle) {
        return 'X';
    }

    return ' ';
}

var renderMazeBody = function (mazeArray, maze) {
    var mazeBody = '';

    for (var heightIterator = 0; heightIterator < maze.height; heightIterator++) {
        mazeBody += '<tr>';

        mazeBody += '<th>' + heightIterator + '</th>';

        for (var widthIterator = 0; widthIterator < maze.width; widthIterator++) {
            mazeBody += '<td>' + renderMazeCell(mazeArray[heightIterator][widthIterator]) + '</td>';
        }

        mazeBody += '</tr>';
    }

    return mazeBody;
}

$('#maze-generator').click(function (event) {
    event.preventDefault();

    var mazeHeader = $('#maze-header');
    var mazeBody = $('#maze-body');

    var mazeWidth = $('#maze-width').val();
    var mazeHeight = $('#maze-height').val();
    var mazeBrickDensity = $('#maze-brick-density').val();
    var mazeStartX = $('#maze-start-x').val();
    var mazeStartY = $('#maze-start-y').val();
    var mazeEndX = $('#maze-end-x').val();
    var mazeEndY = $('#maze-end-y').val();

    $.ajax({
        url: "/api/maze/generate",
        method: "POST",
        data: JSON.stringify({
            "startPointX": mazeStartX,
            "startPointY": mazeStartY,
            "endPointX": mazeEndX,
            "endPointY": mazeEndY,
            "brick_density": mazeBrickDensity,
            "width": mazeWidth,
            "height": mazeHeight
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
