#include<stdio.h>
#include<stdlib.h>
#include<string.h>
#include<math.h>
#include<ctype.h>
#define map_height 40
#define map_width 80
#define NAMESIZE 16
#define DISTANCE(x, y, z, b) sqrt((x-z) * (x-z) + (y-b) * (y-b))     //calcute the distance between two position
#define NONE "\e[0m"
#define CYAN "\e[0;36m"
#define RED "\e[1;31m"

typedef struct AIMINFO{
	char name[NAMESIZE];
	double latitude;
	double longitude;
}aiminfo;


typedef struct List list;
struct List{
	aiminfo target;
	struct List *next;
};

////////////////////////below function is commonly used//////////////////////////

char* s_gets(char *st, int n)       //gets input and deal with useless input(clear buffer)
{
	char * ret_val, * find;
	ret_val = fgets(st, n, stdin);
	if(ret_val)
	{
		find = strchr(st, '\n');	// change the '\n' to '\0'
		if(find)
			*find = '\0';
		else
			while(getchar() != '\n')
				continue;
	}
	return ret_val;
}


void free_struct(list *L)			// free the whole linked list
{  
	while(L->next)
	{
		list *t = L;
		L = L->next;
		free(t);
 	}
	free(L);
}

void buffer_clear(void)				//clear the buffer
{
	char ch;
	while((ch = getchar()) != '\n')	
		continue;
}

int judge_input(const char *prompt[], double arr[]) // use in option 4 and option 5 to check the input
{
	int i = 0 ;
	for (i = 0; i < 3; i++)
	{
		printf("%s", prompt[i]);			//print the prompt message
		char *temp, judge[20], ch;
		while(1)
		{
			if((ch = getchar()) == '\n')	// check input is '\n' or not
				return 0;
			ungetc(ch, stdin);

			s_gets(judge, 20);				// get the input
			arr[i] = strtod(judge, &temp);
			if (temp[0] == '\0')			// if input contain char or not
			{
				if (i != 2)					// this is longitude and latitude it is in the range[0,100]
				{
					if (arr[i] <= 100.0 && arr[i] >= 0.0)
					{
							break;	
					}
					else
					{
						printf("Invalid input. The number is out of range, please input a number between 0 and 100 or press 'enter' back to menu.\n");
					}
				}
				else						// this is range it is in the range[0, +infinite)
				{
					if (arr[i] >= 0.0)
					{
							break;	
					}
					else
					{
						printf("Invalid input. Please input a nonnegative number or press 'enter' back to menu.\n");
					}	
				}
			}
			else
			{
				printf("Invalid input. This is not a valid number, retry with a valid number or press 'enter' back to menu.\n");
			}
			printf("%s", prompt[i]);
		}
	}
	return 1;
}

////////////////////////below is the first option//////////////////////////////////////////

int judge_file(FILE *fp)
{
	int i = 0;			// i use to judge if there are valid 'name value value'
	char ch;
	while((ch = fgetc(fp)) == ' ') 			// get the blank at the beginning of file
		continue;
	if (ch == EOF)							// if file just contain some blank or nothing in the file
		return 0;
	while(ch != EOF)
	{
		if (ch == '\n')						// if there are more than one line
			return 0;
		if(!i)								// this string is the target name
		{
			int len = 0;
			while(ch != ' ' && ch != EOF)
			{
				if(ch == '\n' || !isalnum(ch) || ++len >15)
					return 0;
				ch = fgetc(fp);
			}
		}
		else								// this string is longitude or latitude
		{
			int j = 0;
			double a = 0.0;
			char value[17], *temp;
			while(ch != ' ' && ch != EOF)	// get the char between two blank and save in a list
			{
				if (ch == '\n')
					return 0;
				value[j] = ch;
				j++;
				if(j > 15)					// if over 15 character
					return 0;
				ch = fgetc(fp);
			}
			value[j] = '\0';
			a = strtod(value, &temp);
			if (temp[0] != '\0' || a > 100.0 || a < 0.0)	// check if it is a valid value or not
				return 0;
		}
		++i;
		i %= 3;
		if (ch == '\0')
			break;
		while (ch == ' ')					// eliminate the blank between name and value or value and value
			ch = fgetc(fp);
	}
	if(i)									// judge if there are several complete 'name value value'
		return 0;
	return 1;
}

int judge_conflict(list *L, list *k)
{
	list *temp = L->next;
	while(temp)
	{
		if(DISTANCE(temp->target.latitude, temp->target.longitude, k->target.latitude, k->target.longitude) < 0.1)
			break;		 	// judge if conflict with previous one
		temp = temp->next;
	}
	if(temp)				// if it is conflict with previous one, temp will not loop to the end, so it is not 'NULL'
		return 1;
	return 0;
}

list *store_target(FILE *fp, list *L)				// save the target in the linked list
{
	list *t = L;
	while(t->next)
		t = t->next;

	while(!feof(fp))
	{
		list * k = (list *)malloc(sizeof(list));	// k use to temp save the target.if the target is conflict with previous one, free it
		if(k == NULL)
		{   
			printf("Unable to allocate memory.\n");   
			free_struct(L);
			exit(-1);
		} 
		k->next = NULL; 
		if(fscanf(fp, "%s %lf %lf", k->target.name, &(k->target.latitude), &(k->target.longitude)) == 3)
		{
			if (!judge_conflict(L, k))
			{
				t->next = k;				// if it is not conflict save it at the end of previous structure
				t = t->next;
				continue;
			}
		}
		free(k);
	}
	return L;
}

list *load_file(list *L)
{
	char file_name[100];
	FILE *fp;
	char ch;
	printf("Enter a target file:");
	if((ch = getchar()) == '\n')	// judge if input is '\n'
		return L;
	ungetc(ch, stdin);				// if it is not '\n', put the char back to the buffer

	s_gets(file_name, 100);			// get the file_name and clear the buffer
	if((fp = fopen(file_name, "rb")) == NULL)
	{											// judge if file name is valid
		printf("Invalid file.\n");
		return L;
	}
	if(!judge_file(fp))				// judge if file is suit for the demand
	{
		printf("Invalid file.\n");
		if(fclose(fp))				// check if the file is successfully closed (nearly useless)
		{
			perror("error");
			free_struct(L);
			exit(-2);
		}
		return L;
	}
	fseek(fp, 0, SEEK_SET);			//put the file pointer to the start

	L = store_target(fp, L);		// store the target in structure

	if(fclose(fp))
	{
		perror("error");
		free_struct(L);
		exit(-2);
	}
	return L;
}

////////////////////////below is the second option//////////////////////////////////////////

void print_map(char map[][map_width])
{
	int latitude = 0, longitude = 0;
	for (latitude = 0; latitude < map_height; latitude++)		//print the map
	{
		for(longitude = 0; longitude < map_width; longitude++)
		{
			if (latitude > 4 && isupper(map[latitude][longitude]))		// give different sign different color
				printf(CYAN"%c"NONE, map[latitude][longitude]);
			else if (latitude > 4 && map[latitude][longitude] == '*')
				printf(RED"%c"NONE, map[latitude][longitude]);
			else
				printf("%c", map[latitude][longitude]);
		}
		printf("\n");
	}    
	printf("\n");
}

void show_target(list* L)
{
	if(!(L->next))
		return;
	char map[map_height][map_width] =  {// insteat use loop to creat because it is more directly to show its appearance and change, also, it is comflict to use loop creat this map
		"																				",
		"                        the  map  of  planet  E								",
		"																				",
		"         0    10    20    30    40    50    60    70    80    90   100         ",
		"																				",
		"     0    _____|_____|_____|_____|_____|_____|_____|_____|_____|_____    0     ",
		"         |     |     |     |     |     |     |     |     |     |     | 		",
		"    10  _|_____|_____|_____|_____|_____|_____|_____|_____|_____|_____|_  10	",
		"         |     |     |     |     |     |     |     |     |     |     |			",
		"    20  _|_____|_____|_____|_____|_____|_____|_____|_____|_____|_____|_  20	",
		"         |     |     |     |     |     |     |     |     |     |     |			",
		"    30  _|_____|_____|_____|_____|_____|_____|_____|_____|_____|_____|_  30	",
		"         |     |     |     |     |     |     |     |     |     |     |			",		
		"    40  _|_____|_____|_____|_____|_____|_____|_____|_____|_____|_____|_  40	",
		"         |     |     |     |     |     |     |     |     |     |     |			",
		"    50  _|_____|_____|_____|_____|_____|_____|_____|_____|_____|_____|_  50	",
		"         |     |     |     |     |     |     |     |     |     |     |			",
		"    60  _|_____|_____|_____|_____|_____|_____|_____|_____|_____|_____|_  60	",
		"         |     |     |     |     |     |     |     |     |     |     |			",
		"    70  _|_____|_____|_____|_____|_____|_____|_____|_____|_____|_____|_  70	",
		"         |     |     |     |     |     |     |     |     |     |     |			",
		"    80  _|_____|_____|_____|_____|_____|_____|_____|_____|_____|_____|_  80	",
		"         |     |     |     |     |     |     |     |     |     |     |			",
		"    90  _|_____|_____|_____|_____|_____|_____|_____|_____|_____|_____|_  90	",
		"         |     |     |     |     |     |     |     |     |     |     | 		",
		"   100   |_____|_____|_____|_____|_____|_____|_____|_____|_____|_____|   100 	",
		"               |     |     |     |     |     |     |     |     |     			",
		"																				",
		"         0     10    20    30    40    50    60    70    80    90   100 		",
		"																				",
		"																				",
		"       mention: the target in the map is roughly round-down in the range       ",
		"																				",
		"																				",
		"                the number of target is count from 'A' to 'Z'					",
		"																				",
		"                    if there are more than 26 targets							",
		"																				",
		"                        it will show in map as '*'								",
		"																				"
	};								// initate the map

	int latitude = 0, longitude = 0;
	
	list *t = L->next;
	while(t)
	{							// print all the target and put the targert in the map 
		printf("%s %.6lf %.6lf\n", t->target.name, t->target.latitude, t->target.longitude);
		latitude = t->target.latitude / 5 + 5;
		longitude = t->target.longitude * 60 / 100 + 9;
		if(isupper(map[latitude][longitude]))
		{
			if (map[latitude][longitude] != 'Z')	// if it is less than 27 targets in this range use 'A' to 'Z' to show
				map[latitude][longitude] += 1;
			else
				map[latitude][longitude] = '*';		// if it is >= 27 targets use '*'
		}
		else
		{
			if (map[latitude][longitude] != '*')
				map[latitude][longitude] = 'A';		//if this range has had one or more targets
		}
		t = t->next;
	}

	printf("\n");
	print_map(map);
	printf("\n");
}

////////////////////////below is the third option//////////////////////////////////////////

void search_target(list *L)
{
	if(!(L->next))				// if not target
		return;
	int count = 0;				// judge if the target is exist 
	char search[20], ch;
	list *t = L->next;
	printf("Enter the name: ");
	if((ch = getchar()) == '\n')		// judge if input is '\n'
		return;
	ungetc(ch, stdin);			// if it is not '\n', put the char back to the buffer

	s_gets(search, 20);			// get the input and clear the buffer
	while(t)
	{
		if(!strcmp(search, t->target.name))	// compare if the name is exit
		{
			printf("%s %.6lf %.6lf\n", t->target.name, t->target.latitude, t->target.longitude);
			count = 1;
		}
		t = t->next;
	}
	if(count == 0)				// if no aim target
    	printf("Entry does not exist.\n");
}

////////////////////////below is the forth option//////////////////////////////////////////

void plan_airstrike(list *L)
{
	int n = 0;				// use to record the number of target, only use if no target print message to tell user(this is not given standrad in the demand)
	if(!(L->next))			// if no target
		return;
	double arr[3];			// 0 is latitude, 1 is longitude, 2 is zone
	const char *prompt[3] = {"Enter predicted latitude: ", "Enter predicted longitude: ", "Enter radius of damage zone: "};

	if(judge_input(prompt, arr) == 0)
		return;

	list *t = L->next;
	while(t)				// search if target in the range
	{
		if(DISTANCE(t->target.latitude, t->target.longitude, arr[0], arr[1]) <= arr[2])
		{
			printf("%s %.6lf %.6lf\n", t->target.name, t->target.latitude, t->target.longitude);
			n += 1;
		}
		t = t->next;
	}
	if(!n)
		printf("No target in the range.\n");
}

////////////////////////below is the fifth option//////////////////////////////////////////

int delete_target(list *L, list *n, double *arr)
{
	int destroy = 0;
	list *pre = L;
	list *t = L->next;
 	list *m = n;

	while(t)
	{
		if(DISTANCE(t->target.latitude, t->target.longitude, arr[0], arr[1]) <= arr[2])	// if target in the range will be destroy
		{
			m->next = t;				//store the destroy target in the new linked list
			m = m->next;
			destroy++;					// count the number of destroy

			pre->next = t->next;		// remove the destroy node from the old linked list
			t = t->next;
			m->next = NULL;				// let the BedestoryTarget->next = NULL
		}	
		else
		{
			t = t->next;				// if it is not in the range
			pre = pre->next;    	
		}
	}
	return destroy;		
}

void print_destroy(list *m)
{
	m = m->next;
	while(m)			// print the destroy target
	{
		printf("%s %.6lf %.6lf\n", m->target.name, m->target.latitude, m->target.longitude);
		m = m->next;
	}
}

list *execute_airstrike(list *L)
{
	if(!(L->next))				//if no target
		return L;
	double arr[3];			// 0 is latitude, 1 is longitude, 2 is zone
	const char *prompt[3] = {"Enter targeted latitude: ", "Enter targeted longitude: ", "Enter radius of damage zone: "};

	if(judge_input(prompt, arr) == 0)
		return L;

	int destroy = 0;
	list *n = (list *)malloc(sizeof(list));		// to save the destroy target
	if(n == NULL)
	{   
		printf("Unable to allocate memory.\n");  
		free_struct(L);
		exit(-1);
	}
	n->next = NULL;

	destroy = delete_target(L, n, arr);			//delete the destroy target in L and add them in n

	if(!destroy)			// if no target is destroy
	{
		printf("No target aimed. Mission cancelled.\n");
	}
	else
	{
		printf("%d target destroyed.\n", destroy);
    }
	
	print_destroy(n);		//print the destroy target
	free_struct(n);			// free the targets which have been destroyed
	return L;
}

////////////////////////below is the main function//////////////////////////////////////////

int main(void)
{
	char choose, ch;
	int choice;
	list *L = (list *)malloc(sizeof(list));
	if (L == NULL)
	{
		printf("Unable to allocate memory.\n"); 
		exit(-1);
	}  
	L->next = NULL;

	printf("1) Load a target file\n2) Show current targets\n3) Search a target\n");
	printf("4) Plan an airstrike\n5) Execute an airstrike\n6) Quit\n");
    
	while(1)
	{
		printf("Option: ");
		choose = getchar();
		if(choose == '\n')					//if enter \n  the program will exit;
		{
			free_struct(L);
			return 0;
		}
		else
		{
			if((ch = getchar()) != '\n')			// judge if user input more than one char
			{
				buffer_clear();
				printf("Unknown option.\n");	
				continue;			
			}
			if( (choice = (int)choose - 48) < 0 || choice > 6)	// change char to int and judge if it is the value we need
			{
				printf("Unknown option.\n");
				continue;
			}
		}
		switch (choice)		// different choose
		{
			default:
				printf("Unknow option.\n");
				continue;
			case (1):
				L = load_file(L);
				break;
			case (2):
				show_target(L);
				break;
			case (3):
				search_target(L);
				break;
			case (4):
				plan_airstrike(L);
				break;
			case (5):
				L = execute_airstrike(L);
				break;
			case (6):
				free_struct(L);
				return 0;
		}
	}
}
