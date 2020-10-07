%% load
clear;
load StandardizedInputs.mat;
load targets.mat;

%% train
percentErrors5 = [];
percentErrors10 = [];
percentErrors15 = [];
percentErrors20 = [];
percentErrors25 = [];
percentErrors30 = [];

for i = 1:10
    percentErrors5(i) = Q2c_hidden5;
    percentErrors10(i) = Q2c_hidden10;
    percentErrors15(i) = Q2c_hidden15;
    percentErrors20(i) = Q2c_hidden20;
    percentErrors25(i) = Q2c_hidden25;
    percentErrors30(i) = Q2c_hidden30;
end

percentErrors5 = mean(percentErrors5);
percentErrors10 = mean(percentErrors10);
percentErrors15 = mean(percentErrors15);
percentErrors20 = mean(percentErrors20);
percentErrors25 = mean(percentErrors25);
percentErrors30 = mean(percentErrors30);

%% plot
plot([5,10,15,20,25,30],[percentErrors5, percentErrors10,percentErrors15,percentErrors20,percentErrors25,percentErrors30],'--bs','MarkerEdgeColor','r');
title('percent of Error with different number of hidden nodes.');
xlabel('hidden layer size');
ylabel('percent of Error');
