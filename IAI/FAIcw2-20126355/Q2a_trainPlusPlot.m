%% train 
clear;
load inputs.mat;
load targets.mat;

%% Use all the attributes in inputs
[~, AccuracyAllAttribute] = Q2a_AllAttribute(InputsTable,targets);

%% Use all the attributes in inputs, except the 3 most correlated ones.
[~, AccuracyAllAttributeExceptFirstThree] = Q2a_AllAttrubuteExceptFirstThree(InputsTable,targets);

%% Apply PCA (a dimensionality reduction technique) with the default options using all the attributes in inputs
[~, AccuracyAllAttributeWithPCA] = Q2a_AllAttributeWithPCA(InputsTable,targets);

%% plot
x = {'All Attribute','All Except 3','With PCA'};
y = [AccuracyAllAttribute,AccuracyAllAttributeExceptFirstThree,AccuracyAllAttributeWithPCA];
bar(y, 0.3);
set(gca, 'XTickLabel', x);