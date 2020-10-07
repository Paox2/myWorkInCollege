%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
% Optimal path: starting from the last node, backtrack to
% its parent nodes until it reaches the start node
% 04-26-2005    Copyright 2009-2010 The MathWorks, Inc.
%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%

QUEUE_COUNT = size(QUEUE, 1);
xval = QUEUE(QUEUE_COUNT, 2);
yval = QUEUE(QUEUE_COUNT, 3);

temp = QUEUE_COUNT;         
while(((xval ~= xTarget) || (yval ~= yTarget)) && temp > 0)
    temp = temp - 1;
    xval = QUEUE(temp, 2);
    yval = QUEUE(temp, 3);
end


if ((xval == xTarget) && (yval == yTarget))
    maze(xval, yval) = 4;
    dispMaze(maze);
    inode = 0;
    % Traverse QUEUE and determine the parent nodes
    parent_x = QUEUE(index(QUEUE, xval, yval), 4);
    parent_y = QUEUE(index(QUEUE, xval, yval), 5);
   
    while(parent_x ~= xStart || parent_y ~= yStart)
        i = i + 1;
        maze(parent_x, parent_y) = 6;
        inode = index(QUEUE, parent_x, parent_y); % find the grandparents :)
        parent_x = QUEUE(inode, 4);
        parent_y = QUEUE(inode, 5);
        dispMaze(maze);
    end
    maze(parent_x, parent_y) = 6;
    dispMaze(maze);
else
    pause(1);
    h = msgbox('Oops! No path exists to the Target!', 'warn');
    uiwait(h, 5);
end
