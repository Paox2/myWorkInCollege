%% load the inputs.mat and targets.mat
load("inputs.mat");
load("targets.mat");

accuracy75 = [];
accuracy80 = [];
accuracy85 = [];
accuracy90 = [];
accuracy95 = [];
accuracy100 = [];

%% get the accuracy of using different percent of variance explained in PCA
for i = 1:10
    [~, accuracy75(i)] = Q2b_PCA75(InputsTable, targets);
    [~, accuracy80(i)] = Q2b_PCA80(InputsTable, targets);
    [~, accuracy85(i)] = Q2b_PCA85(InputsTable, targets);
    [~, accuracy90(i)] = Q2b_PCA90(InputsTable, targets);
    [~, accuracy95(i)] = Q2b_PCA95(InputsTable, targets);
    [~, accuracy100(i)] = Q2b_PCA100(InputsTable, targets);
end

accuracy75 = mean(accuracy75);
accuracy80 = mean(accuracy80);
accuracy85 = mean(accuracy85);
accuracy90 = mean(accuracy90);
accuracy95 = mean(accuracy95);
accuracy100 = mean(accuracy100);

%% plot the accuracy
x = 75:5:100;
y = [accuracy75,accuracy80,accuracy85,accuracy90,accuracy95,accuracy100];

%% plot
plot(x,y,'--bs','MarkerEdgeColor','r');
title('accuracy of different percent of variance explained in PCA');
xlabel('percent of variance explained in PCA');
ylabel('accuracy');