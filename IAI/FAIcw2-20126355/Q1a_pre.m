

clear;

%% load the data
dataTrain = readtable("cancer_train.csv");

%% remove the rows where data is missing
dataAfterRemoveNaN = rmmissing(dataTrain,'DataVariables',@isnumeric);

%% remove the first column id
dataAfterRemoveId = removevars(dataAfterRemoveNaN,{'id'});

%% divide data into inputs and targets
inputs = table2array(dataAfterRemoveId(:,2:31));
targetsBeforeConvert = table2array(dataAfterRemoveId(:,1));

%% convert column
targets = [];
n = 1;
while n <= length(targetsBeforeConvert)
    if char(targetsBeforeConvert(n)) == 'M'
        targets(n,1) = 1;
    else
        targets(n,1) = 0;
    end
    n = n + 1;
end

%% mean and std of radius_mean
MeanRadius = mean(dataAfterRemoveNaN.radius_mean);
StdRadius = std(dataAfterRemoveNaN.radius_mean);

%%  standardize each attribute
StandardizedInputs = (inputs - mean(inputs))./std(inputs);

Name = dataTrain.Properties.VariableNames(:,3:32);
InputsTable = array2table(StandardizedInputs, 'VariableNames', Name);

%% save
save('inputs.mat','InputsTable');
save('targets.mat','targets');
save('StandardizedInputs.mat','StandardizedInputs');