
clear;
dataTrain = readtable("cancer_train.csv");
load("inputs.mat");
StandardizedInputs = table2array(InputsTable);

%%  the pairwise correlation of every pair of attributes in inputs
corrInputs = corr(StandardizedInputs);

%% three more correlated
attributeCorr = sum(corrInputs)/30;
[~, Index] = sort(attributeCorr, 'descend');
firstThreeIndex = Index(:,1:3) + 2;
firstThreeCorr = dataTrain.Properties.VariableNames(firstThreeIndex);

save('firstThreeCorr.mat','firstThreeCorr');