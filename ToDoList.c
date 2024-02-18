#include <stdio.h>
#include <stdlib.h>
#include <string.h>
#include <conio.h>
#define MAX_TASKS 100

struct task {
    char description[100];
    int priority;
    int completed;
};

void display_menu() {
    printf("\n--- TO-DO LIST MANAGER ---\n");
    printf("1. Add task\n");
    printf("2. List tasks\n");
    printf("3. Edit task\n");
    printf("4. Delete task\n");
    printf("5. Mark task as completed\n"); 
    printf("6. Exit\n");
}

void add_task(struct task tasks[], int *num_tasks) {
    char description[100];
    int priority;

    printf("\nEnter task description: ");
    scanf(" %[^\n]", description);
    printf("Enter priority (1-5): ");
    scanf("%d", &priority);

    struct task new_task;
    strcpy(new_task.description, description);
    new_task.priority = priority;

    tasks[*num_tasks] = new_task;
    *num_tasks += 1;

    printf("\nTask added!\n");
}

void list_tasks(struct task tasks[], int num_tasks) {
    if (num_tasks == 0) {
        printf("\nNo tasks found.\n");
    } else {
        printf("\nTASKS:\n");
        printf("+----+----------------------------------+----------+-------------------+\n");
        printf("| No | Description                      | Priority | Completion Status |\n");
        printf("+----+----------------------------------+----------+-------------------+\n");
        int i;
        for ( i = 0; i < num_tasks; i++) {
            printf("| %2d | %-32s | %8d | %17s |\n", i+1, tasks[i].description, tasks[i].priority, tasks[i].completed ? "Completed" : "Pending");
        }
        printf("+----+----------------------------------+----------+-------------------+\n");
    }
}

void edit_task(struct task tasks[], int num_tasks) {
    if (num_tasks == 0) {
        printf("\nNo tasks found.\n");
    } else {
        int task_num;
        printf("\nEnter task number to edit: ");
        scanf("%d", &task_num);

        if (task_num <= 0 || task_num > num_tasks) {
            printf("\nInvalid task number.\n");
        } else {
            char description[100];
            int priority;

            printf("Enter new task description: ");
            scanf(" %[^\n]", description);
            printf("Enter new priority (1-5): ");
            scanf("%d", &priority);

            strcpy(tasks[task_num-1].description, description);
            tasks[task_num-1].priority = priority;

            printf("\nTask edited!\n");
        }
    }
}

void delete_task(struct task tasks[], int *num_tasks) {
    if (*num_tasks == 0) {
        printf("\nNo tasks found.\n");
    } else {
        int task_num;
        printf("\nEnter task number to delete: ");
        scanf("%d", &task_num);

        if (task_num <= 0 || task_num > *num_tasks) {
            printf("\nInvalid task number.\n");
        } 
		else 
		{
			int i;
            for ( i = task_num-1; i < *num_tasks-1; i++) {
                tasks[i] = tasks[i+1];
            }
            *num_tasks -= 1;

            printf("\nTask deleted!\n");
        }
    }
}

void complete_task(struct task tasks[], int num_tasks) {
    if (num_tasks == 0) {
        printf("\nNo tasks found.\n");
    } else {
        int task_num;
        printf("\nEnter task number to mark as completed: ");
        scanf("%d", &task_num);

        if (task_num <= 0 || task_num > num_tasks) {
            printf("\nInvalid task number.\n");
        } else {
            tasks[task_num-1].completed = 1;
            printf("\nTask marked as completed!\n");
        }
    }
}

int main() {
	struct task tasks[MAX_TASKS];
    int num_tasks = 0;

    FILE *fp;
    fp = fopen("tasks.dat", "rb");
    if (fp != NULL) {
        fread(&num_tasks, sizeof(num_tasks), 1, fp);
        fread(tasks, sizeof(struct task), num_tasks, fp);
        fclose(fp);
    }

    int choice= 0;
    do {
        display_menu();
        printf("\nEnter your choice: ");
        scanf("%d", &choice);
        switch (choice) {
            case 1:
                add_task(tasks, &num_tasks);
                break;
            case 2:
                list_tasks(tasks, num_tasks);
                break;
            case 3:
                edit_task(tasks, num_tasks);
                break;
            case 4:
                delete_task(tasks, &num_tasks);
                break;
            case 5:
                complete_task(tasks, num_tasks); 
                break;
            case 6:
                printf("\nExiting program...\n");
                fp = fopen("tasks.dat", "wb");
                fwrite(&num_tasks, sizeof(num_tasks), 1, fp);
                fwrite(tasks, sizeof(struct task), num_tasks, fp);
                fclose(fp);
                exit(0);
            default:
                printf("\nInvalid choice. Please try again.\n");
    }
} 
   while (choice != 6);
   return 0;
}


